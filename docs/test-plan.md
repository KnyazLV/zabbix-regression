# Test Plan: Zabbix Regression 7.0.26 vs 7.4.10

## Objective

Verify that Zabbix Agent and HTTP Agent checks behave consistently between the LTS version (7.0.26) and the post-refactoring version (7.4.10).

## Infrastructure

| Component          | Specification                                             |
| ------------------ | --------------------------------------------------------- |
| **Host OS**        | macOS Tahoe Version 26.4.1 (Apple Silicon, arm64)         |
| **Container Host** | Docker Desktop v.4.73.0 (Engine 27.x)                     |
| **Browsers**       | Firefox 150.0.2 (aarch64), Chromium 148.0.7778.96 (arm64) |
| **Base Image OS**  | Alpine Linux 3.20 (Standard for Zabbix images)            |
| **DB Engine**      | PostgreSQL 16.3 (Alpine-based)                            |
| **Networking**     | Bridge mode, isolated per project (-p flag)               |

## Environment

### Zabbix 7.0.26 (Baseline)

| Parameter     | Value                  |
| ------------- | ---------------------- |
| Compose file  | docker/compose-70.yaml |
| Frontend URL  | http://localhost:8070  |
| Zabbix Server | zabbix-server-70:10051 |
| Zabbix Agent  | zabbix-agent-70        |
| Database      | PostgreSQL 16          |

### Zabbix 7.4.10 (Target)

| Parameter     | Value                  |
| ------------- | ---------------------- |
| Compose file  | docker/compose-74.yaml |
| Frontend URL  | http://localhost:8074  |
| Zabbix Server | zabbix-server-74:10051 |
| Zabbix Agent  | zabbix-agent-74        |
| Database      | PostgreSQL 16          |

## Deployment Instructions

```bash
docker compose -f docker/compose-70.yaml -p zabbix-70 up -d
docker compose -f docker/compose-74.yaml -p zabbix-74 up -d
```

## Test Execution Strategy

To ensure test independence:

1. Each manual test suite is executed on a dedicated host named `TMP-{{TS_ID}}` from the `Test` host group. A shared host per suite allows test cases within a suite to build on each other's state where needed.
2. After successful completion, the host is deleted. In case of failure, it remains for debugging.
3. For Zabbix Agent tests, the host interface is linked to the DNS name of the agent container from the Docker network (`zabbix-agent-74` or `zabbix-agent-70`).
4. Automated tests use a separate host per test case (`TMP-{{TC_ID}}`), created at the start and deleted during teardown, to keep each automated check fully independent.

## Automation Notes

A small subset of regression checks is automated with Selenium + PHP.

Automation runtime:

| Component       | Version                               |
| --------------- | ------------------------------------- |
| PHP             | 8.3.31                                |
| PHPUnit         | 11.5.55                               |
| Selenium Server | 4.43.0                                |
| Chromium        | 147.0.7727.55                         |
| Selenium image  | `selenium/standalone-chromium:latest` |

All automated checks use the item form **Test** function to validate returned values through the UI. This avoids relying on asynchronous history updates immediately after creating a new item, which is unreliable due to configuration cache update delays.

## Approach

Each test case is executed independently on both versions. Manual and automated results are compared between
the baseline and target versions. Deviations in behavior are logged in the report.

## Entry Criteria

- Both Docker environments are up and healthy.
- Zabbix Frontend is reachable via defined URLs.
- Connectivity: `zabbix-server` can resolve and reach `zabbix-agent` via internal DNS names.

## Exit Criteria

- All test cases executed on both versions
- All findings documented

# Navigation

- [Traceability Matrix](../test-cases/traceability-matrix.md)
- [Report](../reports/regression-report.md)
- [README](../README.md)
