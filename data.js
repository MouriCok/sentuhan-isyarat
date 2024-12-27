import * as tf from '@tensorflow/tfjs';
import fs from 'fs';
import path from 'path';
import csv from 'csvtojson';

const datasetPath = path.join(process.cwd(), 'datasets');

const loadDataset = async (filename) => {
    const filePath = path.join(datasetPath, filename);
    console.log(`Loading dataset from: ${filePath}`);
    const csvData = fs.readFileSync(filePath, 'utf8');
    const jsonData = await csv().fromString(csvData);
    return jsonData;
};

export { loadDataset };
