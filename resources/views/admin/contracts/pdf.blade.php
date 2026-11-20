<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
@page { margin: 35px 42px; }
body { font-family: DejaVu Sans, sans-serif; color:#222; font-size:11px; line-height:1.55; }
.header { border-bottom:2px solid #333; padding-bottom:12px; margin-bottom:22px; }
.brand { font-size:22px; font-weight:bold; letter-spacing:1px; }
.muted { color:#666; }
h1 { font-size:19px; margin:0 0 5px; }
h2 { font-size:13px; margin:18px 0 6px; border-bottom:1px solid #ddd; padding-bottom:4px; }
table { width:100%; border-collapse:collapse; }
td,th { padding:6px; border:1px solid #ddd; text-align:left; vertical-align:top; }
.signatures { margin-top:55px; width:100%; }
.signatures td { border:0; width:50%; padding:18px 12px 0 0; }
.line { border-top:1px solid #333; padding-top:6px; margin-top:35px; }
.footer { position:fixed; bottom:-18px; left:0; right:0; text-align:center; color:#777; font-size:9px; }
</style>
</head>
<body>
<div class="header">
    <div class="brand">LAYERLOOP</div>
    <div class="muted">Contract & Legal Management</div>
</div>
<h1>{{ $contract->title }}</h1>
<div class="muted">{{ $contract->contract_number }} · Version {{ $contract->version }} · {{ $contract->type?->name }}</div>

<h2>1. Parties</h2>
<p>This agreement is made between LayerLoop (the first party) and <strong>{{ $contract->party_name }}</strong>
@if($contract->company_name) of {{ $contract->company_name }} @endif
(the second party).</p>
<p><strong>Address:</strong> {{ $contract->address }} {{ $contract->city }} {{ $contract->state }} {{ $contract->country }}</p>
<p><strong>Email:</strong> {{ $contract->email }} &nbsp; <strong>Phone:</strong> {{ $contract->phone }}</p>

<h2>2. Agreement period and scope</h2>
<p><strong>Business unit:</strong> {{ config('layerloop-contracts.business_units.'.$contract->business_unit, $contract->business_unit) }}</p>
<p><strong>Period:</strong> {{ $contract->start_date?->format('d M Y') ?? 'To be agreed' }} to {{ $contract->end_date?->format('d M Y') ?? 'As agreed in writing' }}</p>
<p><strong>Territory:</strong> {{ $contract->territory_type ?: 'As expressly agreed by the parties' }}</p>
<p><strong>Exclusivity:</strong> {{ $contract->is_exclusive ? 'Exclusive, subject to the defined scope and territory' : 'Non-exclusive' }}</p>
<p>{{ $contract->scope_of_work }}</p>
@if($contract->description)<p>{{ $contract->description }}</p>@endif
@if($contract->special_restrictions)<p><strong>Special restrictions:</strong> {{ $contract->special_restrictions }}</p>@endif

<h2>3. Covered products / designs</h2>
<table><thead><tr><th>Product / Model</th><th>Code</th><th>Restriction</th><th>Remarks</th></tr></thead><tbody>
@forelse($contract->products as $product)
<tr><td>{{ $product->product_name }}</td><td>{{ $product->product_code }}</td><td>{{ $product->restriction_type }}</td><td>{{ $product->remarks }}</td></tr>
@empty<tr><td colspan="4">No specific product list attached.</td></tr>@endforelse
</tbody></table>

<h2>4. Terms and conditions</h2>
@forelse($contract->conditions as $i => $condition)
<p><strong>{{ $i+1 }}. {{ $condition->condition_title }}</strong><br>{{ $condition->condition_description }}</p>
@empty<p>Additional terms must be attached in writing and signed by both parties.</p>@endforelse

<h2>5. Commercial terms</h2>
<p><strong>Payment:</strong> {{ $contract->payment_amount !== null ? 'INR '.number_format((float)$contract->payment_amount,2).' ('.$contract->payment_type.')' : 'As separately agreed in writing' }}</p>
<p>{{ $contract->payment_terms }}</p>

<h2>6. General provisions</h2>
<p>This document records the commercial terms entered by the parties. Applicable law, dispute resolution, intellectual property ownership, limitation of liability, notices, severability and other legal provisions should be completed in the approved template before issue. Any amendment must be in writing and signed by authorized representatives.</p>

<table class="signatures"><tr>
<td><div class="line"><strong>For LayerLoop</strong><br>Name:<br>Designation:<br>Date:</div></td>
<td><div class="line"><strong>For {{ $contract->party_name }}</strong><br>Name:<br>Designation:<br>Date:</div></td>
</tr><tr><td><div class="line">Witness 1</div></td><td><div class="line">Witness 2</div></td></tr></table>
<div class="footer">Generated document · {{ $contract->contract_number }} · Page 1</div>
</body></html>
