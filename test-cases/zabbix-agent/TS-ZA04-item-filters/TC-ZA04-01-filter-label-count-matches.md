# TC-ZA04-01 – Subfilter panel reflects correct categories and item counts

**Suite**: [TS-ZA04](../../traceability-matrix.md#ts-za04--item-filters) – item-filters\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-13\
**Updated**: 2026-05-13

## Description

Verify that the subfilter panel on the Items page correctly reflects all filter
categories based on the items configured on the host. Each subfilter value must
display an accurate count of items matching that property.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-ZA04` test host is active.
- An authorized user.

## Test Data

### Items

| Field               | Item 1             | Item 2                 | Item 3            |
| ------------------- | ------------------ | ---------------------- | ----------------- |
| Name                | Uptime             | Disk Total             | Hostname          |
| Type                | Zabbix agent       | Zabbix agent           | Zabbix agent      |
| Key                 | `system.uptime`    | `vfs.fs.size[/,total]` | `system.hostname` |
| Type of information | Numeric (unsigned) | Numeric (unsigned)     | Character         |
| Units               | s                  | B                      | –                 |
| Update interval     | `1m`               | `5m`                   | `1m`              |
| Tags                | `component: os`    | `component: storage`   | `component: os`   |

### Expected subfilter state

| Category            | Value                | Expected count |
| ------------------- | -------------------- | :------------: |
| TAGS                | `component: os`      |       2        |
| TAGS                | `component: storage` |       1        |
| TYPE OF INFORMATION | Numeric (unsigned)   |       2        |
| TYPE OF INFORMATION | Character            |       1        |
| INTERVAL            | `1m`                 |       2        |
| INTERVAL            | `5m`                 |       1        |

## Steps

| #   | Action                                                                                      | Expected Result                                             |
| --- | ------------------------------------------------------------------------------------------- | ----------------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-ZA04` host and click **Items**.     | Items list for the host is displayed.                       |
| 2   | Create all three items using the values from the _"Items"_ table above and save them.       | All three items appear in the list with status "Enabled".   |
| 3   | Locate the subfilter panel on the Items page.                                               | Categories TAGS, TYPE OF INFORMATION, INTERVAL are visible. |
| 4   | Verify each subfilter value and its counter against the _"Expected subfilter state"_ table. | All values are present and all counts match exactly.        |
