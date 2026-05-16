# Traceability Matrix

## Zabbix Agent

### TS-ZA01 – passive-check

| Test Case ID                                                                        | Test Case Title        | v7.0.26  | v7.4.10  | Priority | Automated |
| ----------------------------------------------------------------------------------- | ---------------------- | :------: | :------: | :------: | :-------: |
| [TC-ZA01-01](zabbix-agent/TS-ZA01-passive-check/TC-ZA01-01-agent-ping-returns-1.md) | agent.ping returns `1` | **PASS** | **PASS** |    P1    |    Yes    |

### TS-ZA02 — system-keys

| Test Case ID                                                                             | Test Case Title                     | v7.0.26  | v7.4.10  | Priority | Automated |
| ---------------------------------------------------------------------------------------- | ----------------------------------- | :------: | :------: | :------: | :-------: |
| [TC-ZA02-01](zabbix-agent/TS-ZA02-system-keys/TC-ZA02-01-system-uname-regex-extracts.md) | system.uname regex extracts `Linux` | **PASS** | **PASS** |    P2    |    Yes    |
| [TC-ZA02-02](zabbix-agent/TS-ZA02-system-keys/TC-ZA02-02-memory-size-is-not-zero.md)     | memory.size value is not zero       | **PASS** | **PASS** |    P2    |    No     |

### TS-ZA03 — item-error-handling

| Test Case ID                                                                                                  | Test Case Title                                          | v7.0.26  | v7.4.10  | Priority | Automated |
| ------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------- | :------: | :------: | :------: | :-------: |
| [TC-ZA03-01](zabbix-agent/TS-ZA03-item-error-handling/TC-ZA03-01-item-becomes-notsupported-on-invalid-key.md) | Invalid item key transitions item to NOT SUPPORTED state | **PASS** | **PASS** |    P1    |    No     |

### TS-ZA04 — item-filters

| Test Case ID                                                                              | Test Case Title                       | v7.0.26  | v7.4.10  | Priority | Automated |
| ----------------------------------------------------------------------------------------- | ------------------------------------- | :------: | :------: | :------: | :-------: |
| [TC-ZA04-01](zabbix-agent/TS-ZA04-item-filters/TC-ZA04-01-filter-label-count-matches.md)  | Filter label count matches item count | **PASS** | **PASS** |    P2    |    No     |
| [TC-ZA04-02](zabbix-agent/TS-ZA04-item-filters/TC-ZA04-02-filter-shows-matching-items.md) | Filter shows only matching items      | **PASS** | **PASS** |    P2    |    No     |

### TS-ZA05 — item-managment

| Test Case ID                                                                               | Test Case Title                        | v7.0.26  | v7.4.10  | Priority | Automated |
| ------------------------------------------------------------------------------------------ | -------------------------------------- | :------: | :------: | :------: | --------- |
| [TC-ZA05-01](zabbix-agent/TS-ZA05-item-management/TC-ZA05-01-update-item-configuration.md) | Update existing item configuration     | **PASS** | **PASS** |    P1    | No        |
| [TC-ZA05-02](zabbix-agent/TS-ZA05-item-management/TC-ZA05-02-disable-item.md)              | Disable item and stop data collection  | **PASS** | **PASS** |    P2    | No        |
| [TC-ZA05-03](zabbix-agent/TS-ZA05-item-management/TC-ZA05-03-enable-item.md)               | Enable item and resume data collection | **PASS** | **PASS** |    P2    | No        |
| [TC-ZA05-04](zabbix-agent/TS-ZA05-item-management/TC-ZA05-04-delete-item.md)               | Delete existing item                   | **PASS** | **PASS** |    P1    | No        |

---

## HTTP Agent

### TS-HA01 – http-methods

| Test Case ID                                                                                 | Test Case Title                                  | v7.0.26  | v7.4.10  | Priority | Automated |
| -------------------------------------------------------------------------------------------- | ------------------------------------------------ | :------: | :------: | :------: | :-------: |
| [TC-HA01-01](http-agent/TS-HA01-http-methods/TC-HA01-01-get-request-return-response-body.md) | GET request successfully retrieves response body | **PASS** | **PASS** |    P1    |    Yes    |
| [TC-HA01-02](http-agent/TS-HA01-http-methods/TC-HA01-02-post-with-json-body-succeeds.md)     | POST request with JSON body succeeds             | **PASS** | **PASS** |    P2    |    No     |
| [TC-HA01-03](http-agent/TS-HA01-http-methods/TC-HA01-03-post-with-xml-body-succeeds.md)      | POST request with XML body succeeds              | **PASS** | **PASS** |    P2    |    No     |

### TS-HA02 – response-preprocessing

| Test Case ID                                                                                                   | Test Case Title                                   | v7.0.26  | v7.4.10  | Priority | Automated |
| -------------------------------------------------------------------------------------------------------------- | ------------------------------------------------- | :------: | :------: | :------: | :-------: |
| [TC-HA02-01](http-agent/TS-HA02-response-preprocessing/TC-HA02-01-jsonpath-extracts-value.md)                  | JSONPath extracts correct value from response     | **PASS** | **PASS** |    P1    |    Yes    |
| [TC-HA02-02](http-agent/TS-HA02-response-preprocessing/TC-HA02-02-regex-capture-group-returns-match.md)        | Regex capture group returns expected match        | **PASS** | **PASS** |    P1    |    No     |
| [TC-HA02-03](http-agent/TS-HA02-response-preprocessing/TC-HA02-03-jsonpath-missing-field-sets-notsupported.md) | JSONPath on missing field sets item NOT SUPPORTED | **PASS** | **PASS** |    P1    |    No     |

### TS-HA03 — authentication

| Test Case ID                                                                                 | Test Case Title                                  | v7.0.26  | v7.4.10  | Priority | Automated |
| -------------------------------------------------------------------------------------------- | ------------------------------------------------ | :------: | :------: | :------: | :-------: |
| [TC-HA03-01](http-agent/TS-HA03-authentication/TC-HA03-01-basic-auth-valid-credentials.md)   | Basic Auth with valid credentials returns data   | **PASS** | **PASS** |    P1    |    No     |
| [TC-HA03-02](http-agent/TS-HA03-authentication/TC-HA03-02-basic-auth-invalid-credentials.md) | Basic Auth with invalid credentials sets error   | **PASS** | **PASS** |    P2    |    No     |
| [TC-HA03-03](http-agent/TS-HA03-authentication/TC-HA03-03-bearer-token-in-header.md)         | Bearer token in custom header authorizes request | **PASS** | **PASS** |    P1    |    No     |

### TS-HA04 — ssl-and-redirects

| Test Case ID                                                                                          | Test Case Title                                        | v7.0.26  | v7.4.10  | Priority | Automated |
| ----------------------------------------------------------------------------------------------------- | ------------------------------------------------------ | :------: | :------: | :------: | :-------: |
| [TC-HA04-01](http-agent/TS-HA04-ssl-and-redirects/TC-HA04-01-https-valid-certificate.md)              | HTTPS request with valid certificate succeeds          | **PASS** | **PASS** |    P2    |    No     |
| [TC-HA04-02](http-agent/TS-HA04-ssl-and-redirects/TC-HA04-02-https-invalid-certificate-sets-error.md) | HTTPS request with invalid certificate sets item error | **PASS** | **PASS** |    P2    |    No     |
| [TC-HA04-03](http-agent/TS-HA04-ssl-and-redirects/TC-HA04-03-follow-redirects-returns-200.md)         | Follow redirects returns final response code 200       | **PASS** | **PASS** |    P2    |    No     |

### TS-HA05 — endpoint-unavailability

| Test Case ID                                                                                        | Test Case Title                      | v7.0.26  | v7.4.10  | Priority | Automated |
| --------------------------------------------------------------------------------------------------- | ------------------------------------ | :------: | :------: | :------: | :-------: |
| [TC-HA05-01](http-agent/TS-HA05-endpoint-unavailability/TC-HA05-01-timeout-is-handled-correctly.md) | Request timeout is handled correctly | **PASS** | **PASS** |    P1    |    No     |

# Navigation

- [Test Plan](../docs/test-plan.md)
- [Report](../reports/regression-report.md)
- [README](../README.md)
