# TC-HA03-03 – Bearer token in custom header authorizes request

**Suite**: [TS-HA03](../../traceability-matrix.md#ts-ha03--authentication) – authentication\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that an HTTP Agent item with a Bearer token passed via a custom Authorization header successfully retrieves data from a protected endpoint.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-HA03` test host is active.
- An authorized user with administrative privileges.
- The Zabbix Server container has outbound internet access.

## Test Data

### Item params

| Field                 | Value                        |
| --------------------- | ---------------------------- |
| Name                  | Bearer Token Auth            |
| Type                  | HTTP agent                   |
| Key                   | `http.bearer.auth`           |
| Type of information   | Text                         |
| URL                   | `https://httpbin.org/bearer` |
| Request type          | GET                          |
| Required status codes | 200                          |
| Retrieve mode         | Body                         |
| Update interval       | `1m`                         |

### Headers

| Name          | Value                          |
| ------------- | ------------------------------ |
| Authorization | `Bearer regression-test-token` |

## Steps

| #   | Action                                                                                  | Expected Result                                       |
| --- | --------------------------------------------------------------------------------------- | ----------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-HA03` host and click **Items**. | Items list for the host is displayed.                 |
| 2   | Click **Create item** and fill in the fields using the _"Item params"_ table above.     | Data is accepted without validation errors.           |
| 3   | Add the custom header from the _"Headers"_ table above in the **Headers** section.      | Header is saved correctly.                            |
| 4   | Click **Add** to save the item.                                                         | Item appears in the list with status "Enabled".       |
| 5   | Click **Execute now** in the item row.                                                  | The "Request sent successfully" notification appears. |
| 6   | Open the **latest 500 values** for the item.                                            | The stored value contains `"authenticated": true`.    |
