# Worker Time Tracker Plugin

The **Worker Time Tracker** plugin provides a streamlined solution for tracking the time that workers spend on various tasks in a warehouse or other work environments. This plugin allows you to easily log start and end times, assign workers to specific companies, and generate detailed reports on their work sessions. It's an essential tool for monitoring productivity and ensuring accurate timekeeping for contractors.

## Models

The plugin utilizes the following models:

- **Worker**: Represents the individual workers.
- **Company**: Represents the firms from which workers are hired.
- **WorkSession**: Logs the start and end times of workers' sessions.

## Use Case

### Scenario

If you have a warehouse and hire external employees (Workers) from firms (Companies), this plugin allows these workers to punch in and out when they start and finish their work sessions (WorkSession). At the end of the month, you can export this data for accurate record-keeping.

### Backend Features

- **Create Workers**: Assign them to a company if it already exists.
- **Assign a Code**: Each worker is given a unique code that they will use to identify themselves from the frontend.

### Frontend Features

- **Worker Identification**: Workers enter their provided code. Upon a successful search, the system displays:
  - **Company Details**: Displays the company the worker is attached to, if any.
  - **Last Session Start**: Displays the start time of the last session.
  - **Controls Section**: Punch In and Punch Out buttons.

- **WorkSession History**: Shows the worker’s previous punch times, useful for reviewing their work history.

## Component

- **timeClock**: This component is used in the frontend for workers to punch in and out. It handles the worker identification and displays the relevant information, such as controls, company details, and work session history.

## Plugin Properties

1. **refreshDelayInSeconds**: 
   - **Description**: Controls the auto-refresh behavior of the page when the WorkSessionUser for a particular user is displayed.
   - **Default**: If left blank, the page will not auto-refresh. If set (e.g., 30), the page will refresh after the specified seconds and return to the search screen.

2. **workSessionHistoryItemsPerPage**: 
   - **Description**: Sets the number of items displayed in the WorkSession history at the bottom of the page.
   - **Default**: 5 items per page. You can increase this value as needed.

## Exporting Data

Don't forget to export your data to ensure all worker sessions are accurately recorded and stored!
