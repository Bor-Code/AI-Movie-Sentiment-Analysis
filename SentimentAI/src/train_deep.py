import pandas as pd
import numpy as np
import re
import pickle
from sklearn.model_selection import train_test_split
from tensorflow.keras.preprocessing.text import Tokenizer
from tensorflow.keras.preprocessing.sequence import pad_sequences
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Embedding, LSTM, Dense
from tensorflow.keras.callbacks import EarlyStopping

MAX_KELIME_SAYISI = 10000
MAX_UZUNLUK = 200
EMBEDDING_BOYUTU = 128

def clean_text(text):
    text = text.lower()
    text = re.sub(r'<br />', ' ', text)
    text = re.sub(r'[^a-zA-Z\s]', '', text)
    return text

df = pd.read_csv('../data/imdb_dataset.csv')
df['review'] = df['review'].apply(clean_text)
y = df['sentiment'].map({'positive': 1, 'negative': 0}).values

tokenizer = Tokenizer(num_words=MAX_KELIME_SAYISI)
tokenizer.fit_on_texts(df['review'])
sequences = tokenizer.texts_to_sequences(df['review'])
X = pad_sequences(sequences, maxlen=MAX_UZUNLUK)

with open('../models/tokenizer.pickle', 'wb') as handle:
    pickle.dump(tokenizer, handle, protocol=pickle.HIGHEST_PROTOCOL)

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

model = Sequential()
model.add(Embedding(MAX_KELIME_SAYISI, EMBEDDING_BOYUTU))
model.add(LSTM(64))
model.add(Dense(1, activation='sigmoid'))

model.compile(loss='binary_crossentropy', optimizer='adam', metrics=['accuracy'])

early_stop = EarlyStopping(monitor='val_loss', patience=2)

model.fit(X_train, y_train, batch_size=32, epochs=3, validation_data=(X_test, y_test), callbacks=[early_stop])

model.save('../models/sentiment_dl_model.h5')