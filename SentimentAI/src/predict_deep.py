import re
import pickle
import numpy as np
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing.sequence import pad_sequences

MAX_UZUNLUK = 200

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
    return pred

while True:
    yorum = input("\nReview: ")
    if yorum.lower() == 'q':
        break
    
    sonuc = tahmin_et(yorum)
    
    if sonuc > 0.6:
        print(f"POSITIVE ({sonuc:.4f})")
    elif sonuc < 0.4:
        print(f"NEGATIVE ({sonuc:.4f})")
    else:
        print(f"NEUTRAL ({sonuc:.4f})")