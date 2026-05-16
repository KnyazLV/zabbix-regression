# TC-HA03-01 – Basic Auth with valid credentials returns data

**Suite**: [TS-HA03](../../traceability-matrix.md#ts-ha03--authentication) – authentication\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that an HTTP Agent item configured with valid Basic Auth credentials
successfully retrieves data from a protected endpoint and stores the response body.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-HA03` test host is active.
- An authorized user with administrative privileges.
- The Zabbix Server container has outbound internet access.

## Test Data

### Item params

| Field                 | Value                                              |
| --------------------- | -------------------------------------------------- |
| Name                  | Basic Auth Valid                                   |
| Type                  | HTTP agent                                         |
| Key                   | `http.basic.auth.valid`                            |
| Type of information   | Text                                               |
| URL                   | `https://httpbin.org/basic-auth/testuser/testpass` |
| Request type          | GET                                                |
| Required status codes | 200                                                |
| Retrieve mode         | Body                                               |
| HTTP authentication   | Basic                                              |
| User name             | `testuser`                                         |
| Password              | `testpass`                                         |
| Update interval       | `1m`                                               |

## Steps

| #   | Action                                                                                  | Expected Result                                       |
| --- | --------------------------------------------------------------------------------------- | ----------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-HA03` host and click **Items**. | Items list for the host is displayed.                 |
| 2   | Click **Create item** and fill in the fields using the _"Item params"_ table above.     | Data is accepted without validation errors.           |
| 3   | Click **Add** to save the item.                                                         | Item appears in the list with status "Enabled".       |
| 4   | Click **Execute now** in the item row.                                                  | The "Request sent successfully" notification appears. |
| 5   | Open the **latest 500 values** for the item.                                            | The stored value contains `"authenticated": true`.    |
