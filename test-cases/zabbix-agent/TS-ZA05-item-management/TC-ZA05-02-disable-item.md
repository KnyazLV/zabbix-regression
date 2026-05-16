# TC-ZA05-02 – Disable item and stop data collection

**Suite**: [TS-ZA05](../../traceability-matrix.md#ts-za05--item-management) – item-management\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that disabling an item stops data collection and the item status
changes to "Disabled".

## Preconditions

- The Docker environment has been deployed according to ∂the test plan, and the `TMP-ZA05` test host is active.
- An authorized user with administrative privileges.
- **[TC-ZA05-01](TC-ZA05-01-update-item-configuration.md) has been executed successfully.** Item "Management Test" exists on `TMP-ZA05`.

## Steps

| #   | Action                                                                                  | Expected Result                                          |
| --- | --------------------------------------------------------------------------------------- | -------------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-ZA05` host and click **Items**. | Item "Management Test" is visible with status "Enabled". |
| 2   | Click **Enabled** in the `Management Test` item row actions.                            | Item status changes to "Disabled".                       |
| 3   | Navigate to the **Monitoring -> Latest data**, filter by Host `TMP-ZA05`                | The host must not have any items.                        |
