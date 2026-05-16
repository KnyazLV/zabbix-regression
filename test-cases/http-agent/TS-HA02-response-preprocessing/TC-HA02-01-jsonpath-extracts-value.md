# TC-HA02-01 – JSONPath extracts correct value from response

**Suite**: [TS-HA02](../../traceability-matrix.md#ts-ha02--response-preprocessing) – response-preprocessing\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that an HTTP Agent item with a JSONPath preprocessing step correctly
extracts a specific field from a JSON response and stores it as the item value.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-HA02` test host is active.
- An authorized user with administrative privileges.
- The Zabbix Server container has outbound internet access.

## Test Data

### Item params

| Field                 | Value                                          |
| --------------------- | ---------------------------------------------- |
| Name                  | JSONPath Extract Title                         |
| Type                  | HTTP agent                                     |
| Key                   | `http.jsonpath.extract.title`                  |
| Type of information   | Text                                           |
| URL                   | `https://jsonplaceholder.typicode.com/todos/1` |
| Request type          | GET                                            |
| Required status codes | 200                                            |
| Retrieve mode         | Body                                           |
| Update interval       | `1m`                                           |

### Preprocessing

| Type     | Parameter |
| -------- | --------- |
| JSONPath | `$.title` |

### Expected value

| Field | Value                |
| ----- | -------------------- |
| title | `delectus aut autem` |

## Steps

| #   | Action                                                                                  | Expected Result                                       |
| --- | --------------------------------------------------------------------------------------- | ----------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-HA02` host and click **Items**. | Items list for the host is displayed.                 |
| 2   | Click **Create item** and fill in the fields using the _"Item params"_ table above.     | Data is accepted without validation errors.           |
| 3   | Add a preprocessing step using the _"Preprocessing"_ table above.                       | Preprocessing step is saved correctly.                |
| 4   | Click **Add** to save the item.                                                         | Item appears in the list with status "Enabled".       |
| 5   | Click **Execute now** in the item row.                                                  | The "Request sent successfully" notification appears. |
| 6   | Open the **latest 500 values** for the item.                                            | The stored value equals `delectus aut autem`.         |

## Automation Note

The automated version uses the item form **Test** function instead of **Execute now** and **latest 500 values**, for the same reason as other HTTP Agent tests – cache update delay makes Execute now unreliable right after item creation.

Automated flow:

1. Create a temporary host.
2. Open the host item list.
3. Create an HTTP Agent item using the test data.
4. Add a JSONPath preprocessing step with parameter `$.title`.
5. Use **Test** in the item form.
6. Verify that the result contains `delectus aut autem`.
7. Save the item.
8. Verify that the item appears as `Enabled`.
9. Delete the temporary host during cleanup.
