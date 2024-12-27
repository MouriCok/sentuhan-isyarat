import * as tf from '@tensorflow/tfjs-node-gpu';
import { loadDataset } from './data.js';
import fs from 'fs';
import path from 'path';

console.log("GPU Availability: ", tf.engine().backendName);

// Ensure the models directory exists
const modelPath = path.join(process.cwd(), 'models');
if (!fs.existsSync(modelPath)) fs.mkdirSync(modelPath);

const preprocessData = (data) => {
  console.log("Preprocessing dataset...");
  const xs = data.map((d) => {
    const pixels = Object.values(d)
      .slice(1)
      .map((val) => parseInt(val, 10));
    return tf.tensor(pixels).reshape([28, 28, 1]).div(tf.scalar(255));
  });

  const ys = data.map((d) => tf.oneHot(parseInt(d.label, 10), 24));

  console.log("Finished preprocessing dataset.");
  return { xs: tf.stack(xs), ys: tf.stack(ys) };
};

const calculateClassWeights = (labels) => {
  const totalSamples = labels.length;
  const uniqueLabels = [...new Set(labels)];
  const classCounts = uniqueLabels.map(label => labels.filter(l => l === label).length);
  const classWeights = uniqueLabels.reduce((weights, label, idx) => {
    weights[label] = totalSamples / (classCounts[idx] * uniqueLabels.length);
    return weights;
  }, {});
  return classWeights;
};

// Custom Time Limit Callback
const createTimeLimitCallback = (maxDurationMinutes) => {
  const maxDuration = maxDurationMinutes * 60 * 1000; // Convert minutes to milliseconds
  let startTime;

  return {
    onTrainBegin: async () => {
      startTime = Date.now();
    },
    onEpochEnd: async (epoch, logs) => {
      const elapsedTime = Date.now() - startTime;
      if (elapsedTime > maxDuration) {
        console.log(`Stopping training after ${maxDuration / 60000} minutes.`);
        this.model.stopTraining = true; // Stop training
      }
    },
  };
};

async function trainAndSaveModel() {
  console.log("Loading datasets...");

  const trainDataset = await loadDataset("sign_mnist_train.csv");
  const testDataset = await loadDataset("sign_mnist_test.csv");

  console.log(`Loaded ${trainDataset.length} training samples.`);
  console.log(`Loaded ${testDataset.length} test samples.`);

  console.log("Preprocessing dataset...");
  const { xs: trainXs, ys: trainYs } = preprocessData(trainDataset);
  const { xs: testXs, ys: testYs } = preprocessData(testDataset);
  console.log("Finished preprocessing dataset.");

  const labels = trainDataset.map(d => parseInt(d.label, 10));
  const classWeights = calculateClassWeights(labels);

  console.log("Initializing model...");
  const model = tf.sequential();
  model.add(
    tf.layers.conv2d({
      filters: 32,
      kernelSize: 3,
      activation: "relu",
      inputShape: [28, 28, 1],
    })
  );
  model.add(tf.layers.batchNormalization());
  model.add(tf.layers.maxPooling2d({ poolSize: [2, 2] }));
  model.add(tf.layers.dropout({ rate: 0.25 }));
  
  model.add(
    tf.layers.conv2d({
      filters: 64,
      kernelSize: 3,
      activation: "relu",
      // inputShape: [28, 28, 1],
    })
  );
  model.add(tf.layers.batchNormalization());
  model.add(tf.layers.maxPooling2d({ poolSize: [2, 2] }));
  model.add(tf.layers.dropout({ rate: 0.25 }));
  
  model.add(tf.layers.flatten());
  model.add(
    tf.layers.dense({ 
      units: 128, 
      activation: "relu",
      kernelRegularizer: tf.regularizers.l2({ l2: 0.01 }),
    }));
  model.add(tf.layers.dropout({ rate: 0.5 }));
  model.add(tf.layers.dense({ units: 24, activation: "softmax" }));

  const learningRate = 0.001;
  model.compile({
    optimizer: tf.train.adam(learningRate),
    loss: "categoricalCrossentropy",
    metrics: ["accuracy"],
  });
  console.log("Model initialized.");

  // const timeLimitCallback = createTimeLimitCallback(120); // Set the time limit to 10 minutes

  // let prevValLoss = Infinity; // Initialize prevValLoss to Infinity

  // const earlyStopping = {
  //   onEpochEnd: (epoch, logs) => {
  //     if (epoch > 0 && logs.val_loss > prevValLoss) { // Compare validation loss
  //       console.log("Validation loss increased; stopping early.");
  //       model.stopTraining = true;
  //     }
  //     prevValLoss = logs.val_loss; // Update prevValLoss
  //   },
  // };  

  console.log("Training the model...");

  const totalEpochs = 100;
  await model.fit(trainXs, trainYs, {
    epochs: totalEpochs,
    batchSize: 64,
    validationData: [testXs, testYs],
    classWeight: classWeights,
    callbacks: [
      // earlyStopping,
      // timeLimitCallback,
      {
        onEpochBegin: async (epoch) => {
          console.log(`\nEpoch ${epoch + 1}/${totalEpochs} started...`);
        },
        onEpochEnd: async (epoch, logs) => {
          console.log(`Epoch ${epoch + 1}/${totalEpochs} completed.`);
          console.log(`Loss: ${logs.loss.toFixed(4)},\nAccuracy: ${(logs.acc * 100).toFixed(2)}%,\nValidation Loss: ${logs.val_loss.toFixed(4)},\nValidation Accuracy: ${(logs.val_acc * 100).toFixed(2)}%`
          );
          if (epoch > 0 && logs.val_loss > logs.loss) {
            console.log("Validation loss increased; stopping early.");
            model.stopTraining = true;
          }
        },
      },
    ],
  });

  console.log("Saving the model...");
  await model.save(`file://${modelPath}/signLanguageModel`);
  console.log("Model saved!");
}

trainAndSaveModel();
