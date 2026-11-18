#!flask/bin/python
import json
import os
from flask import Flask, abort, jsonify, make_response
from flask_httpauth import HTTPBasicAuth

auth = HTTPBasicAuth()
app = Flask(__name__)

AUTH_USER = os.environ.get('API_USERNAME', 'admin')
AUTH_PASS = os.environ.get('API_PASSWORD', 'changeme')


@auth.get_password
def get_password(username):
    if username == AUTH_USER:
        return AUTH_PASS
    return None


@auth.error_handler
def unauthorized():
    return make_response(jsonify({'error': 'Unauthorized access'}), 401)


student_age_file_path = os.environ.get('student_age_file_path', '/data/student_age.json')

with open(student_age_file_path, 'r', encoding='utf-8') as student_age_file:
    student_age = json.load(student_age_file)


@app.route('/supmit/api/v1.0/get_student_ages', methods=['GET'])
@auth.login_required
def get_student_ages():
    return jsonify({'student_ages': student_age})


@app.route('/supmit/api/v1.0/get_student_ages/<student_name>', methods=['GET'])
@auth.login_required
def get_student_age(student_name):
    if student_name not in student_age:
        abort(404)
    age = student_age[student_name]
    del student_age[student_name]
    with open(student_age_file_path, 'w', encoding='utf-8') as student_age_file:
        json.dump(student_age, student_age_file, indent=4, ensure_ascii=False)
    return jsonify({student_name: age})


@app.errorhandler(404)
def not_found(error):
    return make_response(jsonify({'error': 'Not found'}), 404)


if __name__ == '__main__':
    debug_mode = os.environ.get('FLASK_DEBUG', 'false').lower() == 'true'
    port = int(os.environ.get('PORT', '5000'))
    app.run(debug=debug_mode, host='0.0.0.0', port=port)
