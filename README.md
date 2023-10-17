# Installing, using and testing user-update app

## Installing app on VPS or WSL (Ubuntu) with Docker Compose

1) Get app from GitHub: 

- Using SSH: <b>git clone git@github.com:spitzer77/testing_task.git</b>
- Using https: <b>git clone https://github.com/spitzer77/testing_task.git </b>
- Alternatively, you can download the ZIP file from the [<> Code] button at <https://github.com/spitzer77/testing_task>

2) Go to app dir running command <b>cd testing_task</b> 

3) Build and start the Docker containers by running <b>docker-compose up -d --build</b>

4) Adjust the permissions for the storage directory by running <b>sudo chmod 777 -R \./storage/</b>

5) Access the Docker container by running <b>docker exec -it api\_project\_app bash</b>, and once inside the container execute the following commands:

- <b>composer install</b>
- <b>php artisan migrate</b>
- verify the status of the cron job by running the command <b>service cron status</b>

# Installing app on Windows 10/11 

1) Get app from GitHub: 

- Using SSH: <b>git clone git@github.com:spitzer77/testing_task.git</b>
- Using https: <b>git clone https://github.com/spitzer77/testing_task.git </b>
- Alternatively, you can download the ZIP file from the [<> Code] button at <https://github.com/spitzer77/testing_task>

2) Go to app dir <b>testing_task</b>

3) Rename file <b>.env.example</b> to <b>.env</b> and put here your current database settings

4) Run command <b>composer install</b>

5) Run command <b>php artisan migrate</b>

6) Run command <b>php artisan serve</b>

7) Run user data update mannualy

## Auto updating user data by Cron job from Docker

The process of updating user data begins automatically after installing the app. Here are the steps involved:

Cron job is set up to run every minute by default, invoking the Laravel scheduler, it can modify in <b>/_docker/app/Dockerfile</b> for the cron job configuration.

The Laravel scheduler runs every two minutes by default. You can modify the scheduler frequency in <b>app/Console/Kernel.php</b> file.

During the update process, the following actions are performed:
- If a user exists in both the API response and the database, the user's data is updated.
- If a user exists in the database but is absent in the API response, a soft-delete operation is performed on that user in the database.

By configuring the cron job and the Laravel scheduler, you can adjust the frequency and timing of the user data update process according to your requirements.

## Manual updating user data

- Direct request http://yourdomain:8876/api/getusers
- Command <b>php artisan schedule:run</b>
- Command <b>php artisan update-users</b>

All this action running the user data update process.

## Display users

To oversee the current updated user data, you can access the following web pages:

1) User Data Web Page: http://yourdomain:8876/getusers

## Display full user data in database 

### Running app with Docker 

PhpMyAdmin Web Page: <http://yourdomain:8080>
- This web page allows you to access via <b>phpMyAdmin</b>, a web-based database management tool.
- Set login credentials: Host: <b>db</b>, username: <b>root</b>, password: <b>root</b>
- After logging in, you can navigate to the <b>Laravel</b> database and locate the <b>user_data table</b> to view the complete user data stored in the database.

### Running app directly without Docker
- In any database tool with your database settings from <b>.env</b>

## About Rest API

The API url http://yourdomain:8876/api/getusers without params get updates user data directly and returns JSON responses in the specified formats:

<table>
<tr>
<td><b>Status</b></td>
<td><b>Message</b></td>
</tr>
<tr>
<td>Success</td>
<td>X users synchronized successfully, Y users was soft deleting</td>
</tr>
<tr>
<td>Error</td>
<td>No content to parse JSON</td>
</tr>
<tr>
<td>Error</td>
<td>Invalid Json</td>
</tr>
<tr>
<td>Error</td>
<td>The :field of Json is required</td>
</tr>
<tr>
<td>Error</td>
<td>Database connect error, or create/update error</td>
</tr>
<tr>
<td>Error</td>
<td>Soft deleting error</td>
</tr>
</table>

## Testing Functionality

Command <b>php artisan test</b> inside app dir <b>testing_task</b> to check the correctness of data for synchronization.
