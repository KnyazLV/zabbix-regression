# TC-ZA02-01 – system.uname regex extracts Linux

**Suite**: [TS-ZA02](../../traceability-matrix.md#ts-za02--system-keys) – system-keys\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that Zabbix Server successfully polls a passive Zabbix Agent using the `system.uname` key
and that regex preprocessing correctly extracts the `Linux` value from the returned string.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-ZA02` test host is active.
- An authorized user with administrative privileges.

## Test Data

### Item params

| Field               | Value                   |
| ------------------- | ----------------------- |
| Name                | System Uname Regex Test |
| Type                | Zabbix agent            |
| key                 | `system.uname`          |
| Type of information | Character               |

### Preprocessing params

| Field      | Value              |
| ---------- | ------------------ |
| Name       | Regular expression |
| Parameters | `^(Linux).*$`      |
| Output     | `\1`               |

## Steps

| #   | Action                                                                                             | Expected Result                                           |
| --- | -------------------------------------------------------------------------------------------------- | --------------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-ZA02` host and click **Items**.            | Items list for the host is displayed.                     |
| 2   | Click **Create item** and fill fields using the _"Item params"_ table above.                       | Data is accepted without validation errors.               |
| 3   | In the **Preprocessing** section, add a regex step using the _"Preprocessing params"_ table above. | Preprocessing step is accepted without validation errors. |
| 4   | Click **Add** to save the item.                                                                    | Item appears in the list with status "Enabled".           |
| 5   | Click **Execute now** in the item list.                                                            | The Request sent successfully notification appears.       |
| 6   | Open the **latest 500 values** for the item.                                                       | The resulting value is equal to `Linux`.                  |

## Automation Note

The automated version uses the item form **Test** function instead of **Execute now** and **latest 500 values**, for the same reason as other Zabbix Agent tests – cache update delay makes Execute now unreliable right after item creation.
Automated flow:

1. Create a temporary host.
2. Open the host item list.
3. Create a Zabbix Agent item using the test data.
4. Add a Regular expression preprocessing step with pattern `^(Linux).*$` and output `\1`.
5. Use **Test** in the item form.
6. Verify that the result equals `Linux`.
7. Save the item.
8. Verify that the item appears as `Enabled`.
9. Delete the temporary host during cleanup.
