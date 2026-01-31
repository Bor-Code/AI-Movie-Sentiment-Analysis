from fastapi import FastAPI
from pydantic import BaseModel
import re
import pickle
import numpy as np
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing.sequence import pad_sequences

MAX_UZUNLUK = 200
print("Model ve Tokenizer yükleniyor...")
model = load_model('../models/sentiment_dl_model.h5')
with open('../models/tokenizer.pickle', 'rb') as handle:
    tokenizer = pickle.load(handle)

def clean_text(text):
    text = text.lower()
    text = re.sub(r'<br />', ' ', text)
    text = re.sub(r'[^a-zA-Z\s]', '', text)
    return text

def tahmin_et(yorum):
    temiz_yorum = clean_text(yorum)
    seq = tokenizer.texts_to_sequences([temiz_yorum])
    padded = pad_sequences(seq, maxlen=MAX_UZUNLUK)
    pred = model.predict(padded)[0][0]
    return float(pred)

app = FastAPI()

class YorumModeli(BaseModel):
    text: str

@app.get("/")
def home():
    return {"mesaj": "Duygu Analizi API Çalışıyor! /predict endpointini kullanın."}

@app.post("/predict")
def predict_sentiment(item: YorumModeli):
    skor = tahmin_et(item.text)  
    if skor > 0.6:
        label = "POSITIVE"
    elif skor < 0.4:
        label = "NEGATIVE"
    else:
        label = "NEUTRAL"       
    return {
        "text": item.text,
        "sentiment": label,
        "score": skor
    }