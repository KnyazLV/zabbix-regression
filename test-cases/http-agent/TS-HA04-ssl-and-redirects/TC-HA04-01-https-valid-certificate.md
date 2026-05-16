# TC-HA04-01 – HTTPS request with valid certificate succeeds

**Suite**: [TS-HA04](../../traceability-matrix.md#ts-ha04--ssl-and-redirects) – ssl-and-redirects\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that the HTTP agent successfully receives a response when sending a request to an HTTPS endpoint with a valid SSL certificate

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-HA04` test host is active.
- An authorized user with administrative privileges.
- The Zabbix Server container has outbound internet access.

## Test Data

### Item params

| Field                 | Value                   |
| --------------------- | ----------------------- |
| Name                  | HTTPS Valid Certificate |
| Type                  | HTTP agent              |
| Key                   | `http.ssl.valid.cert`   |
| Type of information   | Text                    |
| URL                   | `https://badssl.com`    |
| Request type          | GET                     |
| SSL verify peer       | Yes                     |
| SSL verify host       | Yes                     |
| Required status codes | 200                     |
| Retrieve mode         | Body                    |
| Update interval       | `1m`                    |

## Steps

| #   | Action                                                                                  | Expected Result                                       |
| --- | --------------------------------------------------------------------------------------- | ----------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-HA04` host and click **Items**. | Items list for the host is displayed.                 |
| 2   | Click **Create item** and fill in the fields using the _"Item params"_ table above.     | Data is accepted without validation errors.           |
| 3   | Click **Add** to save the item.                                                         | Item appears in the list with status "Enabled".       |
| 4   | Click **Execute now** in the item row.                                                  | The "Request sent successfully" notification appears. |
| 5   | Open the **latest 500 values** for the item.                                            | The stored value is a non-empty string.               |
