# TC-HA01-03 – POST request with XML body succeeds

**Suite**: [TS-HA01](../../traceability-matrix.md#ts-ha01--http-methods) – http-methods\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that an HTTP Agent item performing a POST request with an XML body
to a publicly available endpoint successfully receives and stores the response body.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-HA01` test host is active.
- An authorized user with administrative privileges.
- The Zabbix Server container has outbound internet access.

## Test Data

### Item params

| Field                 | Value                           |
| --------------------- | ------------------------------- |
| Name                  | POST XML Response Body          |
| Type                  | HTTP agent                      |
| Key                   | `http.post.xml.response.body`   |
| Type of information   | Text                            |
| URL                   | `https://postman-echo.com/post` |
| Request type          | POST                            |
| Request body type     | XML data                        |
| Required status codes | 200                             |
| Retrieve mode         | Body                            |
| Update interval       | `1m`                            |

### Request body

Contents of `test-data/payloads/post_body.xml`:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<request>
  <source>zabbix-regression</source>
  <version>7.x</version>
</request>
```

## Steps

| #   | Action                                                                                    | Expected Result                                       |
| --- | ----------------------------------------------------------------------------------------- | ----------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-HA01` host and click **Items**.   | Items list for the host is displayed.                 |
| 2   | Click **Create item** and fill in the fields using the _"Item params"_ table above.       | Data is accepted without validation errors.           |
| 3   | Paste the contents of `test-data/payloads/post_body.xml` into the **Request body** field. | Field accepts the XML content.                        |
| 4   | Click **Add** to save the item.                                                           | Item appears in the list with status "Enabled".       |
| 5   | Click **Execute now** in the item row.                                                    | The "Request sent successfully" notification appears. |
| 6   | Open the **latest 500 values** for the item.                                              | The stored value is a non-empty string.               |
