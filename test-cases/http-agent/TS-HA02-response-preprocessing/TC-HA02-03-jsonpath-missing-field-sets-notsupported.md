# TC-HA02-03 – JSONPath on missing field sets item NOT SUPPORTED

**Suite**: [TS-HA02](../../traceability-matrix.md#ts-ha02--response-preprocessing) – response-preprocessing\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that when a JSONPath expression targets a field that does not exist in the response body, the item transitions to NOT SUPPORTED.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-HA02` test host is active.
- An authorized user with administrative privileges.
- The Zabbix Server container has outbound internet access.

## Test Data

### Item params

| Field                 | Value                                          |
| --------------------- | ---------------------------------------------- |
| Name                  | JSONPath Missing Field                         |
| Type                  | HTTP agent                                     |
| Key                   | `http.jsonpath.missing.field`                  |
| Type of information   | Text                                           |
| URL                   | `https://jsonplaceholder.typicode.com/todos/1` |
| Request type          | GET                                            |
| Required status codes | 200                                            |
| Retrieve mode         | Body                                           |
| Update interval       | `1m`                                           |

### Preprocessing

| Step | Type     | Parameter       |
| ---- | -------- | --------------- |
| 1    | JSONPath | `$.nonexistent` |

## Steps

| #   | Action                                                                                  | Expected Result                                       |
| --- | --------------------------------------------------------------------------------------- | ----------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-HA02` host and click **Items**. | Items list for the host is displayed.                 |
| 2   | Click **Create item** and fill in the fields using the _"Item params"_ table above.     | Data is accepted without validation errors.           |
| 3   | Add a preprocessing step using the _"Preprocessing"_ table above.                       | Preprocessing step is saved correctly.                |
| 4   | Click **Add** to save the item.                                                         | Item appears in the list with status "Enabled".       |
| 5   | Click **Execute now** in the item row.                                                  | The "Request sent successfully" notification appears. |
| 6   | Wait one collection cycle (1m) and refresh the item list.                               | Item status changes to **Not supported**.             |
