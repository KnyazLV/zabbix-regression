# TC-HA02-02 – Regex capture group returns expected match

**Suite**: [TS-HA02](../../traceability-matrix.md#ts-ha02--response-preprocessing) – response-preprocessing\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that an HTTP Agent item with a Regex preprocessing step correctly
extracts a capture group from the response body and stores it as the item value.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-HA02` test host is active.
- An authorized user with administrative privileges.
- The Zabbix Server container has outbound internet access.

## Test Data

### Item params

| Field                 | Value                      |
| --------------------- | -------------------------- |
| Name                  | Regex Extract Title Tag    |
| Type                  | HTTP agent                 |
| Key                   | `http.regex.extract.title` |
| Type of information   | Text                       |
| URL                   | `https://www.google.com`   |
| Request type          | GET                        |
| Required status codes | 200                        |
| Retrieve mode         | Body                       |
| Update interval       | `1m`                       |

### Preprocessing

| Name               | Pattern                 | Output |
| ------------------ | ----------------------- | ------ |
| Regular expression | `<title>(.*?)<\/title>` | `\1`   |

## Steps

| #   | Action                                                                                  | Expected Result                                       |
| --- | --------------------------------------------------------------------------------------- | ----------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-HA02` host and click **Items**. | Items list for the host is displayed.                 |
| 2   | Click **Create item** and fill in the fields using the _"Item params"_ table above.     | Data is accepted without validation errors.           |
| 3   | Add a preprocessing step using the _"Preprocessing"_ table above.                       | Preprocessing step is saved correctly.                |
| 4   | Click **Add** to save the item.                                                         | Item appears in the list with status "Enabled".       |
| 5   | Click **Execute now** in the item row.                                                  | The "Request sent successfully" notification appears. |
| 6   | Open the **latest 500 values** for the item.                                            | The stored value equals `Google`.                     |
