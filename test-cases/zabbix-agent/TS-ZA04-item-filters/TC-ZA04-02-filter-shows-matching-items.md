# TC-ZA04-02 – Subfilter correctly filters items by selected value

**Suite**: [TS-ZA04](../../traceability-matrix.md#ts-za04--item-filters) – item-filters\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that selecting a subfilter value on the Items page filters the displayed
items to only those matching the selected property value.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-ZA04` test host is active.
- An authorized user.
- **[TC-ZA04-01](TC-ZA04-01-filter-label-count-matches.md) has been executed successfully.** The host `TMP-ZA04` already contains
  the three items defined in that test case.

## Steps

| #   | Action                                                                                  | Expected Result                                                               |
| --- | --------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-ZA04` host and click **Items**. | All three items are listed.                                                   |
| 2   | In the subfilter panel under **TAGS**, click `component: os`.                           | Item list updates. Only items tagged `component: os` are displayed (2 items). |
| 3   | Verify that items **Uptime** and **Hostname** are visible and **Disk Total** is not.    | Matches expectation.                                                          |
| 4   | Click `component: os` again to deselect the filter.                                     | All three items are displayed again.                                          |
| 5   | In the subfilter panel under **TYPE OF INFORMATION**, click `Character`.                | Only item **Hostname** is displayed (1 item).                                 |
| 6   | Click `Character` again to deselect the filter.                                         | All three items are displayed again.                                          |
| 7   | In the subfilter panel under **INTERVAL**, click `5m`.                                  | Only item **Disk Total** is displayed (1 item).                               |
| 8   | Click `5m` again to deselect the filter.                                                | All three items are displayed again.                                          |
