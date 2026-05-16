# TC-ZA03-01 – Invalid item key transitions item to NOTSUPPORTED state

**Suite**: [TS-ZA03](../../traceability-matrix.md#ts-za03--item-error-handling) – item-error-handling\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that when a Zabbix Agent item is configured with an invalid key, the server marks the item as `NOTSUPPORTED`.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-ZA03` test host is active.
- An authorized user with administrative privileges.

## Test Data

### Item params

| Field               | Value              |
| ------------------- | ------------------ |
| Name                | Invalid Key Test   |
| Type                | Zabbix agent       |
| Key                 | `invalid.key.test` |
| Type of information | Numeric (unsigned) |
| Update interval     | `30s`              |

## Steps

| #   | Action                                                                                  | Expected Result                                     |
| --- | --------------------------------------------------------------------------------------- | --------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-ZA03` host and click **Items**. | Items list for the host is displayed.               |
| 2   | Click **Create item** and fill fields using the _"Item params"_ table above.            | Data is accepted without validation errors.         |
| 3   | Click **Add** to save the item.                                                         | Item appears in the list with status `"Enabled"`.   |
| 4   | Click **Execute now** in the item list.                                                 | The Request sent successfully notification appears. |
| 5   | Wait one collection cycle (30s) and refresh the item list.                              | Item `Status` changes to **Not supported**.         |
