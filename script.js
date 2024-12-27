import { HandLandmarker, FilesetResolver } from "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.0";
const demosSection = document.getElementById("demos");
let handLandmarker = undefined;
let runningMode = "IMAGE";
let enableWebcamButton;
let webcamRunning = false;
let model = null;

const alphabetMapping = {
    0: 'A', 1: 'B', 2: 'C', 3: 'D', 4: 'E', 5: 'F', 6: 'G', 7: 'H', 8: 'I', 9: 'K', 10: 'L', 11: 'M', 12: 'N', 
    13: 'O', 14: 'P', 15: 'Q', 16: 'R', 17: 'S', 18: 'T', 19: 'U', 20: 'V', 21: 'W', 22: 'X', 23: 'Y'
};

// Load the TensorFlow.js model
const loadModel = async () => {
    model = await tf.loadLayersModel('./models/signLanguageModel/model.json'); // Replace with your model's URL
    console.log("Model loaded successfully.");
};
loadModel();

const createHandLandmarker = async () => {
    const vision = await FilesetResolver.forVisionTasks("https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.0/wasm");
    handLandmarker = await HandLandmarker.createFromOptions(vision, {
        baseOptions: {
            modelAssetPath: `https://storage.googleapis.com/mediapipe-models/hand_landmarker/hand_landmarker/float16/1/hand_landmarker.task`,
            delegate: "GPU"
        },
        runningMode: runningMode,
        numHands: 1
    });
    demosSection.classList.remove("invisible");
};
createHandLandmarker();

const imageContainers = document.getElementsByClassName("detectOnClick");
// Now let's go through all of these and add a click event listener.
for (let i = 0; i < imageContainers.length; i++) {
    // Add event listener to the child element whichis the img element.
    imageContainers[i].children[0].addEventListener("click", handleClick);
}
// When an image is clicked, let's detect it and display results!
async function handleClick(event) {
    if (!handLandmarker) {
        console.log("Wait for handLandmarker to load before clicking!");
        return;
    }
    if (runningMode === "VIDEO") {
        runningMode = "IMAGE";
        await handLandmarker.setOptions({ runningMode: "IMAGE" });
    }
    // Remove all landmarks drawed before
    const allCanvas = event.target.parentNode.getElementsByClassName("canvas");
    for (var i = allCanvas.length - 1; i >= 0; i--) {
        const n = allCanvas[i];
        n.parentNode.removeChild(n);
    }
    // We can call handLandmarker.detect as many times as we like with
    // different image data each time. This returns a promise
    // which we wait to complete and then call a function to
    // print out the results of the prediction.
    const handLandmarkerResult = handLandmarker.detect(event.target);
    console.log(handLandmarkerResult.handednesses[0][0]);
    const canvas = document.createElement("canvas");
    canvas.setAttribute("class", "canvas");
    canvas.setAttribute("width", event.target.naturalWidth + "px");
    canvas.setAttribute("height", event.target.naturalHeight + "px");
    canvas.style =
        "left: 0px;" +
            "top: 0px;" +
            "width: " +
            event.target.width +
            "px;" +
            "height: " +
            event.target.height +
            "px;";
    event.target.parentNode.appendChild(canvas);
    const cxt = canvas.getContext("2d");
    for (const landmarks of handLandmarkerResult.landmarks) {
        drawConnectors(cxt, landmarks, HAND_CONNECTIONS, {
            color: "#00FF00",
            lineWidth: 25
        });
        drawLandmarks(cxt, landmarks, { color: "#FF0000", lineWidth: 25 });
    }
}
/********************************************************************/
const video = document.getElementById("webcam");
const canvasElement = document.getElementById("output_canvas");
const canvasCtx = canvasElement.getContext("2d");
const inputTensorShape = document.getElementById("inputTensorShape");
const inputTensorData = document.getElementById("inputTensorData");
const probabilityData = document.getElementById("probability");
const predictionIndex = document.getElementById("predictionIndex");
const predictionLabel = document.getElementById("predictionLabel");
// Check if webcam access is supported.
const hasGetUserMedia = () => { var _a; return !!((_a = navigator.mediaDevices) === null || _a === void 0 ? void 0 : _a.getUserMedia); };
// If webcam supported, add event listener to button for when user
// wants to activate it.
if (hasGetUserMedia()) {
    enableWebcamButton = document.getElementById("webcamButton");
    enableWebcamButton.addEventListener("click", enableCam);
}
else {
    console.warn("getUserMedia() is not supported by your browser");
}
// Enable the live webcam view and start detection.
function enableCam() {
    if (!handLandmarker) {
        console.log("Wait! objectDetector not loaded yet.");
        return;
    }

    webcamRunning = !webcamRunning;
    enableWebcamButton.innerText = webcamRunning ? "DISABLE PREDICTIONS" : "ENABLE PREDICTIONS";

    if (webcamRunning) {
        const constraints = { video: true };
        navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
            video.srcObject = stream;
            video.addEventListener("loadeddata", predictWebcam);
        });
    }
}
let lastVideoTime = -1;
let results = undefined;
// console.log(video);
async function predictWebcam() {
    canvasElement.style.width = video.videoWidth;
    canvasElement.style.height = video.videoHeight;
    canvasElement.width = video.videoWidth;
    canvasElement.height = video.videoHeight;
    // Now let's start detecting the stream.
    if (runningMode === "IMAGE") {
        runningMode = "VIDEO";
        await handLandmarker.setOptions({ runningMode: "VIDEO" });
    }
    let startTimeMs = performance.now();
    if (lastVideoTime !== video.currentTime) {
        lastVideoTime = video.currentTime;
        results = handLandmarker.detectForVideo(video, startTimeMs);
    }
    canvasCtx.save();
    canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
    if (results?.landmarks) {
        for (const landmarks of results.landmarks) {
            drawConnectors(canvasCtx, landmarks, HAND_CONNECTIONS, {
                color: "#00FF00",
                lineWidth: 5
            });
            drawLandmarks(canvasCtx, landmarks, { color: "#FF0000", lineWidth: 2 });

            if (model) {
                try {
                    // Pass the landmark data array to predictSign
                    const prediction = await predictSign(landmarks);
                    if (prediction !== undefined) {
                        const predictedAlphabet = alphabetMapping[prediction];
                        // console.log("Prediction:", predictedAlphabet);
                        predictionLabel.innerText = `Prediction: ${predictedAlphabet}`;
                    } else {
                        predictionLabel.innerText = "Prediction: Error";
                    }
                } catch (error) {
                    console.error("Prediction error:", error);
                }
            } else {
                console.warn("Model not loaded yet.");
            }            
        }
    }
    canvasCtx.restore();
    // Call this function again to keep predicting when the browser is ready.
    if (webcamRunning === true) {
        window.requestAnimationFrame(predictWebcam);
    }
}

async function predictSign(landmarks) {
    try {
      // Preprocess input data (e.g., landmarks) into a 28x28 tensor
      const inputTensor = tf.tidy(() => {
        const grid = new Float32Array(28 * 28).fill(0);
        landmarks.forEach((landmark) => {
            const x = Math.min(Math.floor(landmark.x * 27), 27); // Scale to 28x28 grid
            const y = Math.min(Math.floor(landmark.y * 27), 27);
          grid[y * 28 + x] = 1; // Mark the presence of the landmark
        });
  
        // Create tensor and reshape to [1, 28, 28, 1]
        return tf.tensor(grid, [1, 28, 28, 1]).div(tf.scalar(255));
      });

      // Validate the tensor
    //   console.log("Input Tensor Shape:", inputTensor.shape);
      inputTensorShape.innerHTML = `<strong>Tensor Shape:</strong> [${inputTensor.shape}]`;
    //   console.log("Input Tensor Data:", inputTensor.dataSync());
      inputTensorData.innerHTML = `${inputTensor.dataSync()}`;
  
      // Load the trained model
      const model = await tf.loadLayersModel('./models/signLanguageModel/model.json');
      if (!model) {
            throw new Error("Model not loaded.");
        }
  
      // Make prediction
      const prediction = model.predict(inputTensor);
      const predictionProbabilities = prediction.dataSync();
      const maxIndex = predictionProbabilities.indexOf(Math.max(...predictionProbabilities));
      const predictedClass = alphabetMapping[maxIndex];
      const predictedProbability = predictionProbabilities[maxIndex];
    //   console.log("Prediction Probabilities: ", predictionProbabilities);
      probabilityData.innerHTML = `<strong>Probability for ${predictedClass}:</strong> ${Math.round(predictedProbability * 100)}%`;
  
      // Get the predicted class
      const predictedIndex = maxIndex;
      inputTensor.dispose(); // Cleanup tensor
      prediction.dispose();

    //   console.log(`Index Prediction: ${predictedIndex}`);
      predictionIndex.innerHTML = `<strong>Index Prediction:</strong> ${predictedIndex}`;
      return predictedIndex;
    } catch (error) {
      console.error('Error during prediction:', error);
      return undefined;
    }
  }
  