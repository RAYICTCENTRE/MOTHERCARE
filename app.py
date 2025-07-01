from flask import Flask, request, jsonify, session, render_template
import mysql.connector
import hashlib

app = Flask(__name__)
app.secret_key = 'your_secret_key'

# Database connection function
def get_db_connection():
    return mysql.connector.connect(
        host='localhost',
        user='root',
        password='',
        database='mothercare_db'
    )

# Login route
@app.route('/login', methods=['POST'])
def login():
    data = request.json
    email = data.get('email')
    password = data.get('password')
    
    conn = get_db_connection()
    cursor = conn.cursor(dictionary=True)
    cursor.execute("SELECT id, username, password_hash, role FROM users WHERE email = %s", (email,))
    user = cursor.fetchone()
    
    if user and hashlib.sha256(password.encode()).hexdigest() == user['password_hash']:
        session['user_id'] = user['id']
        session['role'] = user['role']
        return jsonify({'message': 'Login successful', 'role': user['role']}), 200
    else:
        return jsonify({'error': 'Invalid credentials'}), 401

# Patients route (GET request)
@app.route('/patients', methods=['GET'])
def get_patients():
    conn = get_db_connection()
    cursor = conn.cursor(dictionary=True)
    cursor.execute("SELECT * FROM patients")
    patients = cursor.fetchall()
    return jsonify(patients)

# Home route (renders HTML page)
@app.route('/')
def home():
    return render_template('index.html')

# Run the application
if __name__ == '__main__':
    app.run(debug=True)
