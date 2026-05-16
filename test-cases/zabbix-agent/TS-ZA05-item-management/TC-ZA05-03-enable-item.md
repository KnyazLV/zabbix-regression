# TC-ZA05-03 – Enable item and resume data collection

**Suite**: [TS-ZA05](../../traceability-matrix.md#ts-za05--item-management) – item-management\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that re-enabling a disabled item resumes data collection and new values appear in Latest Data.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-ZA05` test host is active.
- An authorized user with administrative privileges.
- **[TC-ZA05-02](TC-ZA05-02-disable-item.md) has been executed successfully.** Item "Management Test" is currently disabled.

## Steps

| #   | Action                                                                                  | Expected Result                                                  |
| --- | --------------------------------------------------------------------------------------- | ---------------------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-ZA05` host and click **Items**. | Item "Management Test" is visible with status "Disabled".        |
| 2   | Click **Disabled** in the `Management Test`item row actions.                            | Item status changes to "Enabled".                                |
| 3   | Click **Execute now** in the item row actions.                                          | The "Request sent successfully" notification appears.            |
| 4   | Open the “500 latest values” section in the item.                                       | A new value is present with a timestamp after the enable action. |
