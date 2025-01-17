import pymysql
import os

# Establish the MySQL connection
def create_connection():
    return pymysql.connect(
        host='localhost',
        user='root',          # Replace with your MySQL username
        password='',  # Replace with your MySQL password
        database='pct'   # Replace with your MySQL database name
    )

# Function to upload all files in a folder to the database
def upload_files_from_folder(folder_path):
    connection = create_connection()
    cursor = connection.cursor()

    # Iterate through all files in the folder
    for filename in os.listdir(folder_path):
        file_path = os.path.join(folder_path, filename)

        # Ensure it's a file (not a subfolder)
        if os.path.isfile(file_path):
            try:
                with open(file_path, 'rb') as file:
                    file_data = file.read()

                    # Prepare the SQL query to insert the file into the database
                    query = "INSERT INTO event_gallery (event_name, filename, file_data) VALUES ('SnehaMilan_11-01-2025',%s, %s)"
                    cursor.execute(query, (filename, file_data))

                print(f"Uploaded: {filename}")
            except Exception as e:
                print(f"Failed to upload {filename}: {e}")

    # Commit the changes and close the connection
    connection.commit()
    cursor.close()
    connection.close()
    print("All files uploaded successfully.")

# Example usage
folder_path = '/Applications/XAMPP/xamppfiles/htdocs/PCT/sneha_milan_pct'  # Replace with your folder path containing files
upload_files_from_folder(folder_path)

# ****************************RENAMING***********************
# import os

# # Set the path to your folder containing the images
# folder_path = '/Applications/XAMPP/xamppfiles/htdocs/PCT/sneha_milan_pct'

# # Get a list of all files in the folder
# files = os.listdir(folder_path)

# # Filter out only image files (you can adjust the extensions if necessary)
# image_extensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp']
# image_files = [f for f in files if os.path.splitext(f)[1].lower() in image_extensions]

# # Sort the files (optional: based on filename or creation time)
# image_files.sort()

# # Rename each image
# for idx, image in enumerate(image_files, start=1):
#     # Get the file extension
#     ext = os.path.splitext(image)[1]
    
#     # Create the new file name
#     new_name = f"snehamilan_{idx}{ext}"
    
#     # Get the full path for both the current and new file names
#     old_file = os.path.join(folder_path, image)
#     new_file = os.path.join(folder_path, new_name)
    
#     # Rename the file
#     os.rename(old_file, new_file)
#     print(f"Renamed '{image}' to '{new_name}'")
    
# print("Renaming complete!")
