# TC-ZA05-01 – Update existing item configuration

**Suite**: [TS-ZA05](../../traceability-matrix.md#ts-za05--item-management) – item-management\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that an existing item configuration can be updated and the changes are
saved and applied correctly.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-ZA05` test host is active.
- An authorized user with administrative privileges.

## Test Data

### Item params

| Field               | Value              |
| ------------------- | ------------------ |
| Name                | Management Test    |
| Type                | Zabbix agent       |
| Key                 | `system.uptime`    |
| Type of information | Numeric (unsigned) |
| Units               | s                  |
| Update interval     | `1m`               |

### Updated item params

| Field           | New Value |
| --------------- | --------- |
| Units           | uptime    |
| Update interval | `2m`      |

## Steps

| #   | Action                                                                                  | Expected Result                                              |
| --- | --------------------------------------------------------------------------------------- | ------------------------------------------------------------ |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-ZA05` host and click **Items**. | Items list for the host is displayed.                        |
| 2   | Create the item using the _"Item params"_ table and save it.                            | Item appears in the list with status "Enabled".              |
| 3   | Click on the item name to open its configuration.                                       | Item configuration form is displayed.                        |
| 4   | Apply changes from the _"Updated item params"_ table and click **Update**.              | Success notification appears.                                |
| 5   | Reopen the item configuration.                                                          | Updated values are persisted: interval `2m`, units `uptime`. |
