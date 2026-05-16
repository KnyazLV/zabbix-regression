# Regression Report – Zabbix 7.0.26 vs 7.4.10

| Field    | Value                                |
| -------- | ------------------------------------ |
| Date     | 2026-05-16                           |
| Tester   | Rostislavs Belovs                    |
| Versions | v7.0.26 (baseline), v7.4.10 (target) |
| Status   | **PASS**                             |

## Summary

| Metric  | v7.0.26 | v7.4.10 |
| :-----: | :-----: | :-----: |
|  Total  |   23    |   23    |
|  PASS   |   23    |   23    |
|  FAIL   |    0    |    0    |
| BLOCKED |    0    |    0    |
|  SKIP   |    0    |    0    |

4 test cases were also covered by automated checks. Automated execution result: `OK (8 tests, 16 assertions)`, execution time `01:22.566`.

## Conclusion

All 23 test cases passed successfully on both versions. No functional regressions were found in the tested area (Zabbix Agent and HTTP Agent metric types). One UI change was found in the item test result dialog between versions – see OBS-01. It does not affect functionality.

## Findings & Observations

| ID     | Description                             | Affected Version | Type      |
| ------ | --------------------------------------- | :--------------: | --------- |
| OBS-01 | Test result panel DOM structure changed |     v7.4.10      | UI Change |

### OBS-01 – DOM structure changed in the test result panel (v7.4.10)

The DOM structure in the item test result panel is different between versions. In v7.4.10, the result display area uses new CSS classes (`item-final-result`, `final-result-row`), and a “Copy to clipboard” button (`js-copy-button`) was added next to the value. In v7.0.26, a simpler markup is used without these additions.

This is a UI improvement, not a defect. It does not affect item functionality, but the automated test that reads the result from the **Test** dialog had to support both markup variants.

## Testing Notes

### Configuration cache delay and Execute now

During automation, it was noticed that the `Create item -> Execute now -> Latest values` scenario is not stable for newly created items. Zabbix Server uses a configuration cache, and a new item may not be available for normal execution until the cache is updated.

Because of this, **Execute now** is not the best option for immediately checking an item that was just created during an automated test. The Zabbix UI also suggests using the **Test** function for newly created items or discovery rules.

For automated checks, the **Test** function in the item form was used. It validates the item configuration and returns the actual result directly in the UI. Because of this, HTTP Agent and Zabbix Agent checks in automated tests validate the result through **Test**, not through **Execute now**.

### Session cookie conflict between versions

When working with two Zabbix versions in the same browser at the same time, there was a session conflict: after logging in to one version, the session became invalid in the other version and also in the current tab. Both versions showed this message:

> _You are not logged in. Possibly the session has expired._

The reason is that both versions were opened on `localhost`, but on different ports, and used the same session cookie name. For manual testing, the sessions were separated. One version was opened in a normal browser window, and the other one in incognito mode.

### Frontend structure and UI locators

The Zabbix frontend was convenient for automation. Most elements have stable `id` attributes, classes, or a predictable DOM structure. The main difficulty was only with custom components such as `z-select`, which are not native HTML `<select>` elements and need separate handling in Selenium.

# Navigation

- [Test Plan](../docs/test-plan.md)
- [Traceability Matrix](../test-cases/traceability-matrix.md)
- [README](../README.md)
