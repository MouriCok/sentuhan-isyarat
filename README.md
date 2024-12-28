# Sign Language Detection with TensorFlow.js and MediaPipe

## Overview
This project enables real-time sign language detection and recognition using **TensorFlow.js** and **MediaPipe HandLandmarker**. The app allows users to capture hand gestures, train custom models using their dataset, and predict alphabets dynamically through a webcam interface.

---

## Features
- **Real-time Hand Landmark Detection**: Leverages MediaPipe HandLandmarker for accurate hand landmark extraction.
- **Custom Dataset Creation**: Capture hand gestures for each alphabet (A–Z) and save them as a structured dataset.
- **Dynamic Model Training**: Train a TensorFlow.js model on custom datasets or pre-existing ones (e.g., sign_mnist).
- **Alphabet Prediction**: Predicts sign language alphabets dynamically based on live hand gestures.
- **Interactive UI**: Provides buttons for capturing gestures, saving datasets, and starting webcam predictions.

---

## How It Works
1. **Hand Detection**: MediaPipe extracts hand landmarks in real-time from webcam input.
2. **Dataset Generation**: Users capture snapshots of gestures with corresponding labels, creating a dataset in `.csv` format.
3. **Model Training**: Train a TensorFlow.js model on the dataset to classify hand gestures into alphabets.
4. **Real-time Prediction**: The trained model predicts the alphabet displayed by the user's hand via webcam.

---

### Example Website
- **Link:** [Sentuhan Isyarat](https://mouricok.github.io/sentuhan-isyarat/)
