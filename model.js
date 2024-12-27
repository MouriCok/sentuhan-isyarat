import * as tf from '@tensorflow/tfjs';

// Function to create the model
export function createModel(numClasses) {
    const model = tf.sequential();

    // Convolutional layers
    model.add(tf.layers.conv2d({
        inputShape: [224, 224, 1], // Grayscale images (1 channel)
        filters: 32,
        kernelSize: 3,
        activation: 'relu'
    }));
    model.add(tf.layers.maxPooling2d({ poolSize: [2, 2] }));

    model.add(tf.layers.conv2d({
        filters: 64,
        kernelSize: 3,
        activation: 'relu'
    }));
    model.add(tf.layers.maxPooling2d({ poolSize: [2, 2] }));

    model.add(tf.layers.flatten());
    model.add(tf.layers.dense({ units: 128, activation: 'relu' }));
    model.add(tf.layers.dense({ units: numClasses, activation: 'softmax' }));

    // Compile the model
    model.compile({
        optimizer: 'adam',
        loss: 'categoricalCrossentropy',
        metrics: ['accuracy']
    });

    console.log('Model created successfully');
    return model;
}
