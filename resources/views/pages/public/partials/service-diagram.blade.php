@switch($area)
    @case('backend_engineering')
        <svg class="service-diagram" viewBox="0 0 48 48" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <rect x="8" y="9" width="32" height="9" rx="2" />
            <rect x="8" y="21" width="32" height="9" rx="2" />
            <rect x="8" y="33" width="32" height="6" rx="2" />
            <path class="service-diagram-accent" d="M13 13.5h7M13 25.5h7M13 36h7" />
            <circle class="service-diagram-accent-fill" cx="34" cy="13.5" r="1.5" />
            <circle cx="34" cy="25.5" r="1.5" />
        </svg>
        @break

    @case('apis_integrations')
        <svg class="service-diagram" viewBox="0 0 48 48" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <path d="M15 15 24 24m9-9-9 9m0 0-9 9m9-9 9 9" />
            <circle cx="13" cy="13" r="5" />
            <circle cx="35" cy="13" r="5" />
            <circle cx="13" cy="35" r="5" />
            <circle cx="35" cy="35" r="5" />
            <circle class="service-diagram-accent-fill" cx="24" cy="24" r="4" />
        </svg>
        @break

    @case('software_architecture')
        <svg class="service-diagram" viewBox="0 0 48 48" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <rect x="8" y="8" width="13" height="13" rx="2" />
            <rect x="27" y="8" width="13" height="13" rx="2" />
            <rect x="8" y="27" width="13" height="13" rx="2" />
            <rect x="27" y="27" width="13" height="13" rx="2" />
            <path class="service-diagram-accent" d="M21 14.5h6M14.5 21v6M33.5 21v6M21 33.5h6" />
        </svg>
        @break

    @case('full_stack_applications')
        <svg class="service-diagram" viewBox="0 0 48 48" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <rect x="8" y="8" width="32" height="10" rx="2" />
            <rect x="12" y="21" width="24" height="8" rx="2" />
            <rect x="16" y="32" width="16" height="8" rx="2" />
            <path class="service-diagram-accent" d="M13 13h9M17 25h8M21 36h6" />
        </svg>
        @break

    @case('devops_infrastructure')
        <svg class="service-diagram" viewBox="0 0 48 48" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <path d="M9 24h8m7 0h8m7 0h1M20 20l4 4-4 4m8-4 4 4-4 4" />
            <circle cx="9" cy="24" r="4" />
            <circle cx="20" cy="24" r="4" />
            <circle cx="31" cy="24" r="4" />
            <circle class="service-diagram-accent-fill" cx="40" cy="24" r="4" />
            <path class="service-diagram-accent" d="M9 13v-3h30v3M9 35v3h30v-3" />
        </svg>
        @break

    @case('saas_internal_tools')
        <svg class="service-diagram" viewBox="0 0 48 48" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <rect x="7" y="9" width="34" height="30" rx="3" />
            <path d="M7 17h34M16 17v22" />
            <path class="service-diagram-accent" d="M11 13h.1M14 13h.1M11 22h2m-2 5h2m-2 5h2" />
            <rect x="21" y="22" width="7" height="6" rx="1" />
            <rect x="31" y="22" width="6" height="6" rx="1" />
            <path d="M21 32h16" />
        </svg>
        @break
@endswitch
