from flask import Flask, render_template, request, redirect, url_for, jsonify
import sqlite3
from sqlite3 import Error
from collections import defaultdict
from datetime import datetime

app = Flask(__name__)

# Create a function to fetch data from the database

# Sample data for demonstration purposes


# past_months_data1 = {
#     "2023": [4.5, 3.2, 6.7, 4.8, 5.2, 5.9, 6.1, 5.5, 6.3, 5.6, 4.9, 5.1],
#     "2022": [3.9, 4.2, 3.8, 4.1, 4.7, 5.2, 4.8, 4.9, 4.5, 4.3, 3.7, 4.0],
#     "2021": [2.8, 3.1, 2.9, 3.5, 3.8, 3.6, 3.2, 3.4, 3.7, 3.5, 3.3, 3.1]
# }

# time_series_data = {
#     "time_series": [1.2, 2.3, 3.5, 4.2, 3.8, 4.5, 5.1, 4.7, 5.2, 6.1, 5.5, 4.9, 5.3, 4.8, 5.2, 5.9, 6.1, 5.5, 6.3, 5.6, 5.9, 4.5, 3.2, 6.7, 4.8]
# }

extension = ""
efms_db_file = f"{extension}efms_db.db"

def efms_get_phone_numbers():
    try:
        conn = sqlite3.connect(efms_db_file,check_same_thread=False)
            
    except Error as e:
        print(e)

    cursor = conn.cursor()
    cursor.execute("SELECT * FROM phonenumber")
    data = cursor.fetchall()
    conn.close()
    return data
# Function to fetch data from the SQLite database
def efms_fetch_data(year=None):
    conn = sqlite3.connect(efms_db_file,check_same_thread=False)
    if year:
        query = f"SELECT date, water_level FROM level11 WHERE strftime('%Y', date) = '{year}'"
    else:
        query = "SELECT date, water_level FROM level11"
    data = conn.execute(query).fetchall()
    conn.close()
    return data
@app.after_request
def add_header(response):
    response.headers['Cache-Control'] = 'no-store, no-cache, must-revalidate, max-age=0'
    response.headers['Pragma'] = 'no-cache'
    response.headers['Expires'] = '0'
    return response

@app.route('/efms')
def efms_index():
    return render_template('efms_index.html')

@app.route('/efms-register')
def efms_register():
    return render_template('efms_register.html')

@app.route('/efms-trial')
def efms_trial():
    return render_template('trial.html')
# Define a route to render the HTML template
@app.route('/efms-add-phone')
def efms_add_phone():
    phone_numbers = efms_get_phone_numbers()
    return render_template('efms_phone.html', phone_numbers=phone_numbers)

@app.route('/efms-dashboard')
def efms_dashboard():
    try:
        conn = sqlite3.connect(efms_db_file,check_same_thread=False)
        cursor = conn.cursor()
        
        # Query the data
        cursor.execute("SELECT * FROM level11")
        result = cursor.fetchall()

        # Create a dictionary to store the data
        past_months_data = {}

        # Iterate through the data and populate the dictionary
        for item in result:
            _, water_level, date, _ = item
            year, month, _ = date.split('-')

            if year not in past_months_data:
                past_months_data[year] = []

            past_months_data[year].append(float(water_level))

        # Optionally, you can sort the values within each year if needed
        for year in past_months_data:
            past_months_data[year] = sorted(past_months_data[year], reverse=True)

        # Now, past_months_data contains the data in the desired format
        print(past_months_data)
    except Error as e:
        print(e)
    return render_template("efms_dashboard.html", years = list(past_months_data.keys()))

@app.route('/efms-delete/<int:user_id>', methods=['GET', 'POST'])
def efms_delete_user(user_id):
    if request.method == 'GET':
        # Handle the POST request to delete the user
        try:
            conn = sqlite3.connect(efms_db_file,check_same_thread=False)
            cursor = conn.cursor()
            cursor.execute("DELETE FROM phonenumber WHERE id = ?", (user_id,))
            conn.commit()
            conn.close()
            return redirect(url_for('efms_add_phone'))
        except Error as e:
            print(e)
        

    return render_template('efms_delete_user.html', user_id=user_id)

@app.route('/efms-add-number', methods=['POST'])
def efms_add_number():
    if request.method == 'POST':
        new_name = request.form['name']
        new_phone = request.form['number']
        print(new_phone, new_name)


        try:
            conn = sqlite3.connect(efms_db_file,check_same_thread=False)
            cursor = conn.cursor()
            cursor.execute("INSERT INTO phonenumber(name, number) VALUES (?, ?)", (new_name, new_phone))
            conn.commit()
            conn.close()

            
        except Error as e:
            print(e)

    return redirect(url_for('efms_add_phone'))     
        
@app.route('/efms-login', methods=['POST'])
def efms_login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']
        try:
            conn = sqlite3.connect(efms_db_file,check_same_thread=False)
            cur = conn.cursor()
            cur.execute("SELECT * FROM admins WHERE username=? AND password=?",(username,password,))
            rows = cur.fetchall()
            if len(rows)==1:
                return redirect(url_for('efms_dashboard'))
        except Error as e:
            print(e)
        

        return redirect(url_for('efms_index')) 
@app.route('/efms-registration', methods=['POST'])
def efms_registration():
    if request.method == 'POST':
        new_username = request.form['username']
        new_password = request.form['password']
        print(new_username,new_password)
        try:
            conn = sqlite3.connect(efms_db_file,check_same_thread=False)
            cur = conn.cursor()
            # Define the SQL query for the INSERT operation
            insert_query = "INSERT INTO admins (username, password) VALUES (?, ?)"

            # Execute the INSERT query with the provided data
            cur.execute(insert_query, (new_username, new_password))
            conn.commit()
            conn.close()
        except Error as e:
            print(e)
        

        return render_template("efms_confirm_registration.html")

@app.route('/efms-reports')
def efms_reports():
    conn = sqlite3.connect(efms_db_file,check_same_thread=False)
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM level11")
    data = cursor.fetchall()
    conn.close()
    

    unique_years = set()
    for entry in data:
        date_str = entry[2]  # Assuming the date is always in the third position
        year = date_str.split('-')[0]  # Extracting the year part from the date
        unique_years.add(year)

    # Convert set to sorted list
    sorted_unique_years = sorted(unique_years)
    return render_template('efms-reports.html', data=data, sorted_unique_years = sorted_unique_years)

@app.route('/get_chart_data', methods=['POST'])
def efms_get_chart_data():
    year = request.json.get('year')
    data = efms_fetch_data(year)
    return jsonify(data)


@app.route('/api/currentFloodLevel')
def efms_get_current_flood_level():

    try:
        conn = sqlite3.connect(efms_db_file,check_same_thread=False)
        cursor = conn.cursor()
        cursor.execute("SELECT * FROM level11")
        data = cursor.fetchall()
        conn.close()
        current_flood_level = {
        "location": "Sample Location",
        "current_level": data[len(data)-1][1]
        }    
        
    except Error as e:
        print(e)

        current_flood_level = {
            "location": "Sample Location",
            "current_level": 0.0
            }    
    return jsonify(current_flood_level)

    
    

@app.route('/api/pastMonthsData')
def efms_get_past_months_data():
    year = int(request.args.get('year'))
    try:
        conn = sqlite3.connect(efms_db_file,check_same_thread=False)
        cursor = conn.cursor()
        
        # Query the data
        cursor.execute("SELECT * FROM level11")
        result = cursor.fetchall()

        toSend = [0,0,0,0,0,0,0,0,0,0,0,0]



        for item in result:
            _, water_level, date, _ = item
            year, month, _ = date.split('-')
            if float(water_level)>toSend[int(month)-1]:
                toSend[int(month)-1] = float(water_level)

    except Error as e:
        print(e)

    return jsonify({"year": year, "data": toSend})

@app.route('/api/timeSeriesData')
def efms_get_time_series_data():
    try:
        conn = sqlite3.connect(efms_db_file,check_same_thread=False)
        cursor = conn.cursor()
        
        # Query the data
        cursor.execute("SELECT * FROM level11")
        result = cursor.fetchall()
        time_series_data = {
        "time_series": result 
        }
        return jsonify(time_series_data)
    except Error as e:
        print(e)
    time_series_data = {
        "time_series": [0,0,0] 
    }
    return


def efms_query_database(search_term):
    dat = efms_get_phone_numbers()
    return_data = []
    for a in dat:
        for b in a:
            if isinstance(b, str):
                if search_term.lower() in b.lower():
                    return_data.append(a)

    return return_data

@app.route('/efms-search', methods=['POST'])
def efms_search():
    search_term = request.form['search_term']
    if len(search_term):
        results = efms_query_database(search_term)  
    else:
        conn = sqlite3.connect(efms_db_file,check_same_thread=False)
        cursor = conn.cursor()
        cursor.execute("SELECT * FROM phonenumber")
        results = cursor.fetchall()
    return {"rows":results}

@app.route('/efms-print', methods=['POST'])
def efms_print():
    selectedMethod = request.form['selectedMethod']
    conn = sqlite3.connect(efms_db_file,check_same_thread=False)
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM level11")
    results = cursor.fetchall()
    if selectedMethod=="All":
        return {"rows":results} 
    else:
        monthly_data = defaultdict(list)

        # Parse the data and group by month
        for item in results:
            value = item[1]
            date_str = item[2]
            date = datetime.strptime(date_str, '%Y-%m-%d')
            month = date.strftime('%B %Y')

            monthly_data[month].append(value)

        # Calculate the average for each month
        average_monthly_data = {}
        for month, values in monthly_data.items():
            average = sum(values) / len(values)
            average_monthly_data[month] = average
        average_monthly_set = set(average_monthly_data.items())
        results = sorted(average_monthly_set, key=lambda x: datetime.strptime(x[0], '%B %Y'))
        print(results)
        
    
    return {"rows":results}

@app.route('/efms-insert', methods=['POST'])
def efms_insert_data():
    try:
        data = request.get_json()
        water_level = data.get('level')
        if water_level is not None:
            import datetime

            # Get the current date and time
            current_datetime = str(datetime.datetime.now()).split(" ")
            conn = sqlite3.connect(efms_db_file,check_same_thread=False)
            cursor = conn.cursor()
            cursor.execute("INSERT INTO level11(water_level, date, time) VALUES (?,?,?)", (water_level, current_datetime[0], current_datetime[1]))
            conn.commit()
            conn.close()
            return jsonify({"message": "Water level inserted successfully"})
        else:
            return jsonify({"error": "Invalid data provided"})
    except Exception as e:
        return jsonify({"error": str(e)})

@app.route('/efms-get-numbers')
def get_numbers():

    conn = sqlite3.connect(efms_db_file,check_same_thread=False)
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM phonenumber")
    results = cursor.fetchall()
    str1 = ""
    for xx in results:
        str1 += f"{xx[1]},{xx[2]},"
    return str1
@app.route('/efms-update-number', methods=['POST'])
def efms_update_number():
    if request.method == 'POST':
        new_id = request.form['id']
        new_name = request.form['name']
        new_phone = request.form['number']
        print(new_phone, new_name, new_id)

        try:
            conn = sqlite3.connect(efms_db_file, check_same_thread=False)
            cursor = conn.cursor()
            cursor.execute("UPDATE phonenumber SET name = ?, number = ? WHERE id = ?", (new_name, new_phone, new_id))
            conn.commit()
            conn.close()

        except Error as e:
            print(e)

    return redirect(url_for('efms_add_phone'))
    
if __name__ == '__main__':
    app.run(debug=True)
