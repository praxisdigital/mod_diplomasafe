
# Name: Diplomasafe

## Repository
mod_diplomasafe

## Type
Activity Module (mod)

## Dependencies
None

## Description
This activity allows storing templates and issuing diplomas for Diplomasafe.com. Templates are marked as valid if all the mapped diploma fields exists remotely. In case of errors regarding diploma fields contact Diplomasafe and ask for the following diploma fields to be set up remotely on the template:
- moodle_course_date
  - Remote ID test: 305
  - Remote ID prod: 231
- moodle_course_period
  - Remote ID test: 306
  - Remote ID prod: 232
- moodle_duration
  - Remote ID test: 302
  - Remote ID prod: 233
- moodle_instructor
  - Remote ID test: 304
  - Remote ID prod: 235
- moodle_location
  - Remote ID test: 303
  - Remote ID prod: 234

The teacher (or user with the capability to edit the course) will then be able to create a Diplomasafe activity in the course and select a language and template for the Diplomas in the course in the module settings. After this has been set up Diplomas will automatically be added to the queue every time a course has been completed by a student. When the queue has been processed by the task scheduler in Moodle an email is sent to the student with a link to the newly created diploma.

Templates:
- Fetched by the cron job through the API:
  <website_url>/admin/tool/task/scheduledtasks.php
  - In case of an error: A message is logged in Moodle and sent to the admin (users assigned a role with the "mod/diplomasafe:receive_api_error_mail" capability in course context).
  - Get an overview of the stored templates from this URL:
  <website_url>/mod/diplomasafe/view.php?view=templates_list

Diplomas:
- Added to the queue by the course completed event.
- Diplomas are generated afterwards by the queue handler which is triggered by scheduled tasks in Moodle:
  <website_url>/admin/tool/task/scheduledtasks.php
  - The queue can be managed from this URL:
  <website_url>/mod/diplomasafe/view.php?view=queue_list
  - In case of an error: A message is logged in the queue (visible in the above view) and sent to the admin (users assigned a role with the "mod/diplomasafe:receive_api_error_mail" capability in course context).

## Backup
Supported by the plugin.

## Release notes
* **1.0.0**
    - First release.

## Setup
Install the plugin into the **mod/** directory.

Go into the settings view:
<website_url>/admin/settings.php?section=modsettingdiplomasafe

Switch the environment from test to prod and add your Diplomasafe API access token.
