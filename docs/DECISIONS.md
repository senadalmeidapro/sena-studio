# Decisions

- 2026-10-01: Admin access uses users.is_admin; users holding the legacy admin role are promoted before permission tables are removed.
- 2026-10-01: Activity logs were written during lead pipeline and post management actions, but no workflow depends on them; the log UI, writes, and table are removed.
- 2026-10-01: Analytics uses one trusted deployment setting, services.analytics.script, injected only in the public layout when configured.
