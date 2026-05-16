# Zabbix Regression: 7.0.26 vs 7.4.10

Regression test suite comparing Zabbix **7.0.26** (LTS baseline) against **7.4.10** (post-refactoring target). Covers two metric types: HTTP Agent and Zabbix Agent. Includes 23 test cases across 10 test suites, with a subset covered by Selenium + PHP automation.

## Quick Start

Both environments run in Docker. Default credentials: `Admin` / `zabbix`.

| Version           | URL                   |
| ----------------- | --------------------- |
| 7.0.26 (baseline) | http://localhost:8070 |
| 7.4.10 (target)   | http://localhost:8074 |

Start both environments:

```bash
docker compose -f docker/compose-70.yaml -p zabbix-70 up -d
docker compose -f docker/compose-74.yaml -p zabbix-74 up -d
```

### Run automated tests

Start Selenium services, then run the test suite:

```bash
docker compose -f docker/compose-selenium.yaml -p zabbix-automation up -d --build
docker compose -f docker/compose-selenium.yaml -p zabbix-automation run --rm php-tests composer test
```

Automated test cases (executed against both versions):

- `TC-HA01-01` – HTTP Agent GET request returns response body
- `TC-HA02-01` – JSONPath preprocessing extracts expected value
- `TC-ZA01-01` – `agent.ping` returns `1`
- `TC-ZA02-01` – `system.uname` regex extracts `Linux`

## Structure

```
automation/  Selenium + PHP test suite
docker/      Compose files per version
docs/        Test plan
reports/     Test run report
test-cases/  Test suites by metric type
```

## Docs

- [Test Plan](docs/test-plan.md)
- [Report](reports/regression-report.md)
- [Traceability Matrix](test-cases/traceability-matrix.md)
