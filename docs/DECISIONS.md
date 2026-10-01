# Decisions

- 2026-10-01: Admin access uses users.is_admin; users holding the legacy admin role are promoted before permission tables are removed.
- 2026-10-01: Activity logs were written during lead pipeline and post management actions, but no workflow depends on them; the log UI, writes, and table are removed.
- 2026-10-01: Analytics uses one trusted deployment setting, services.analytics.script, injected only in the public layout when configured.
- 2026-10-01: Stack entries are merged into skills by name; each project inherits all skills from its former stack, and only the legacy /stack 301 remains.
- 2026-10-01: Project skill proficiency and global skill levels are removed because the public Skills page presents association and category only.
- 2026-10-01: Existing infrastructure records are flattened into project deployment text before their table is dropped; signed protected project links have no expiry and are hidden from indexing.
- 2026-10-01: The existing engineering CV layout is the sole CV template; draft, published, and primary CV versions remain.
