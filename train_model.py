import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from sklearn.ensemble import RandomForestClassifier
import joblib

# Example dataset (replace with real data or expand as necessary)
data = {
    'age': [22, 25, 30, 35, 28],
    'weight': [60, 65, 70, 75, 80],
    'blood_pressure': [120, 130, 140, 135, 128],
    'glucose': [90, 95, 100, 110, 105],
    'protein_in_urine': [0.1, 0.2, 0.3, 0.2, 0.4],
    'family_history': [1, 0, 1, 1, 0],
    'target': [0, 0, 1, 1, 0]  # 0 = No preeclampsia, 1 = Yes preeclampsia
}

# Convert to DataFrame
df = pd.DataFrame(data)

# Features and target
X = df.drop(columns=['target'])
y = df['target']

# Split the data into train and test sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Feature scaling
scaler = StandardScaler()
X_train_scaled = scaler.fit_transform(X_train)
X_test_scaled = scaler.transform(X_test)

# Train the model
model = RandomForestClassifier()
model.fit(X_train_scaled, y_train)

# Save the model and scaler to files
joblib.dump(model, 'preeclampsia_model.pkl')
joblib.dump(scaler, 'scaler.pkl')

print("Model and scaler have been saved successfully.")
