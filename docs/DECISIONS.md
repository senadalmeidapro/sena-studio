# Decisions

- 2026-10-01: Admin access uses users.is_admin; users holding the legacy admin role are promoted before permission tables are removed.
- 2026-10-01: Activity logs were written during lead pipeline and post management actions, but no workflow depends on them; the log UI, writes, and table are removed.
- 2026-10-01: Analytics uses one trusted deployment setting, services.analytics.script, injected only in the public layout when configured.
- 2026-10-01: Stack entries are merged into skills by name; each project inherits all skills from its former stack, and only the legacy /stack 301 remains.
- 2026-10-01: Project skill proficiency and global skill levels are removed because the public Skills page presents association and category only.
- 2026-10-01: Existing infrastructure records are flattened into project deployment text before their table is dropped; signed protected project links have no expiry and are hidden from indexing.
- 2026-10-01: The existing engineering CV layout is the sole CV template; draft, published, and primary CV versions remain.
- 2026-10-01: Contact budget ranges remain proposal references rather than guessed fees; EUR amounts use cents, XOF amounts use whole units, and engagement amounts stay optional until agreed.
- 2026-10-01: The portfolio niche defaults to backend and product engineering for fintech and ed-tech, including EU regulatory context; validate this positioning before launch.
- 2026-10-01: Contact scoping answers are stored as project type, goal, timeline, budget range, and optional context; existing budget values are copied before the old field is dropped.
- 2026-10-01: Availability and booking URL live in one singleton site settings row, while each project links to at most one testimonial and may show one manually entered headline metric.
