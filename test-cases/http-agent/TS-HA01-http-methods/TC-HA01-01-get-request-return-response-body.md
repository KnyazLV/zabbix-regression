# TC-HA01-01 – GET request successfully retrieves response body

**Suite**: [TS-HA01](../../traceability-matrix.md#ts-ha01--http-methods) – http-methods\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that an HTTP Agent item performing a GET request to a publicly available
endpoint successfully retrieves the response body and stores it without errors.
A non-empty body and a Normal item status confirm that the request completed
with a successful response.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-HA01` test host is active.
- An authorized user with administrative privileges.
- The Zabbix Server container has outbound internet access.

## Test Data

### Item params

| Field               | Value                                          |
| ------------------- | ---------------------------------------------- |
| Name                | GET Response Body                              |
| Type                | HTTP agent                                     |
| Key                 | `http.get.response.body`                       |
| Type of information | Text                                           |
| URL                 | `https://jsonplaceholder.typicode.com/todos/1` |
| Request method      | GET                                            |
| Retrieve mode       | Body                                           |
| Update interval     | `1m`                                           |

## Steps

| #   | Action                                                                                  | Expected Result                                                                              |
| --- | --------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-HA01` host and click **Items**. | Items list for the host is displayed.                                                        |
| 2   | Click **Create item** and fill in the fields using the _"Item params"_ table above.     | Data is accepted without validation errors.                                                  |
| 3   | Click **Add** to save the item.                                                         | Item appears in the list with status "Enabled".                                              |
| 4   | Click **Execute now** in the item row.                                                  | The "Request sent successfully" notification appears.                                        |
| 5   | Open the **latest 500 values** for the item.                                            | Contains a field with non-empty JSON, whose value includes `“title”`: `“delectus aut autem”` |

## Automation Note

The automated version of this test validates the HTTP Agent GET request through the item form **Test** function instead of using **Execute now** and **latest 500 values**.

Automated flow:

1. Create a temporary host.
2. Open the host item list.
3. Create an HTTP Agent item using the test data.
4. Use **Test** in the item form.
5. Verify that the returned response body contains `delectus aut autem`.
6. Save the item.
7. Verify that the item appears as `Enabled`.
8. Delete the temporary host during cleanup.
