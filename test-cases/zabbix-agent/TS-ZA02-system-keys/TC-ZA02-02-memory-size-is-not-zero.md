# TC-ZA02-02 – memory.size value is not zero

**Suite**: [TS-ZA02](../../traceability-matrix.md#ts-za02--system-keys) – system-keys\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that Zabbix Server successfully polls a passive Zabbix Agent using the `vm.memory.size[available]` key
and returns a numeric value greater than zero.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-ZA02` test host is active.
- An authorized user with administrative privileges.

## Test Data

### Item params

| Field               | Value                       |
| ------------------- | --------------------------- |
| Name                | Memory Size Test            |
| Type                | Zabbix agent                |
| key                 | `vm.memory.size[available]` |
| Type of information | Numeric (unsigned)          |
| Units               | B                           |

## Steps

| #   | Action                                                                                  | Expected Result                                      |
| --- | --------------------------------------------------------------------------------------- | ---------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-ZA02` host and click **Items**. | Items list for the host is displayed.                |
| 2   | Click **Create item** and fill fields using the _"Item params"_ table above.            | Data is accepted without validation errors.          |
| 3   | Click **Add** to save the item.                                                         | Item appears in the list with status "Enabled".      |
| 4   | Click **Execute now** in the item list.                                                 | The Request sent successfully notification appears.  |
| 5   | Open the **latest 500 values** for the item.                                            | The resulting value is numeric and greater than `0`. |
