# Vuexy integration notes

- Replace `@extends('layouts/contentNavbarLayout')` with the master layout used by your project.
- Ensure jQuery and DataTables assets are loaded by your layout.
- The sample table uses Yajra's `DataTables` facade.
- The sample create/edit form is the core details form. Add a Select2 product repeater and condition repeater before enabling issuance.
- Add a sidebar menu link:
  ```blade
  <li class="menu-item">
      <a href="{{ route('admin.contracts.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-scale"></i>
          <div>Contracts</div>
      </a>
  </li>
  ```
