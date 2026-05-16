# TC-HA04-03 – Follow redirects returns final response code 200

**Suite**: [TS-HA04](../../traceability-matrix.md#ts-ha04--ssl-and-redirects) – ssl-and-redirects\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that the HTTP Agent item follows an HTTP redirect and stores the response body from the final destination URL.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-HA04` test host is active.
- An authorized user with administrative privileges.
- The Zabbix Server container has outbound internet access.

## Test Data

### Item params

| Field                 | Value                                                         |
| --------------------- | ------------------------------------------------------------- |
| Name                  | Follow Redirect                                               |
| Type                  | HTTP agent                                                    |
| Key                   | `http.follow.redirect`                                        |
| Type of information   | Text                                                          |
| URL                   | `https://httpbin.org/redirect-to?url=https://httpbin.org/get` |
| Request type          | GET                                                           |
| Follow redirects      | Yes                                                           |
| Required status codes | 200                                                           |
| Retrieve mode         | Body                                                          |
| Update interval       | `1m`                                                          |

## Steps

| #   | Action                                                                                  | Expected Result                                       |
| --- | --------------------------------------------------------------------------------------- | ----------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-HA04` host and click **Items**. | Items list for the host is displayed.                 |
| 2   | Click **Create item** and fill in the fields using the _"Item params"_ table above.     | Data is accepted without validation errors.           |
| 3   | Click **Add** to save the item.                                                         | Item appears in the list with status "Enabled".       |
| 4   | Click **Execute now** in the item row.                                                  | The "Request sent successfully" notification appears. |
| 5   | Open the **latest 500 values** for the item.                                            | The stored value is a non-empty JSON string.          |
