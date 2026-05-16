# TC-ZA05-04 – Delete existing item

**Suite**: [TS-ZA05](../../traceability-matrix.md#ts-za05--item-management) – item-management\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that an existing item can be permanently deleted and no longer appears
in the item list or Latest Data.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-ZA05` test host is active.
- An authorized user with administrative privileges.
- **[TC-ZA05-03](TC-ZA05-03-enable-item.md) has been executed successfully.** Item "Management Test" exists and is enabled.

## Steps

| #   | Action                                                                                  | Expected Result                                              |
| --- | --------------------------------------------------------------------------------------- | ------------------------------------------------------------ |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-ZA05` host and click **Items**. | Item "Management Test" is visible in the list.               |
| 2   | Select the item checkbox and click **Delete**.                                          | Confirmation dialog appears.                                 |
| 3   | Confirm the deletion.                                                                   | Success notification appears. Item is no longer in the list. |
| 4   | Navigate to **Monitoring -> Latest Data** and search for the item.                      | Item "Management Test" is not present.                       |
