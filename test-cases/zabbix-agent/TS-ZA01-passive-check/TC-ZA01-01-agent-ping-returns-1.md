# TC-ZA01-01 – agent.ping returns 1

**Suite**: [TS-ZA01](../../traceability-matrix.md#ts-za01--passive-check) – passive-check\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-12\
**Updated**: 2026-05-12

## Description

Verify that Zabbix Server successfully polls a passive Zabbix Agent and receives
the expected value of `1`, confirming data collection pipeline functionality.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-ZA01` test host is active.
- An authorized user with administrative privileges.

## Test Data

### Item params

| Field               | Value              |
| ------------------- | ------------------ |
| Name                | Agent Ping Test    |
| Type                | Zabbix agent       |
| key                 | `agent.ping`       |
| Type of information | Numeric (unsigned) |
| Update interval     | `30s`              |

## Steps

| #   | Action                                                                                  | Expected Result                                    |
| --- | --------------------------------------------------------------------------------------- | -------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-ZA01` host and click **Items**. | Items list for the host is displayed.              |
| 2   | Click **Create item** and fill fields using the _"Item params"_ table above.            | Data is accepted without validation errors.        |
| 3   | Click **Add** to save the item.                                                         | Item appears in the list with status "Enabled".    |
| 4   | Click **Execute now** in the item list.                                                 | The Request sent successfully notification appears |
| 5   | Open the **latest 500 values** for the item                                             | The resulting values are equal to "1"              |

## Automation Note

The automated version uses the item form **Test** function instead of **Execute now** and **latest 500 values**, because a newly created item may not be picked up by the server cache in time for Execute now to work reliably.
Automated flow:

1. Create a temporary host.
2. Open the host item list.
3. Create a Zabbix Agent item using the test data.
4. Use **Test** in the item form.
5. Verify that the result equals `1`.
6. Save the item.
7. Verify that the item appears as `Enabled`.
8. Delete the temporary host during cleanup.
