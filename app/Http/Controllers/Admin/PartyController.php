<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\StorePartyRequest;
use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function index()
    {
        return view('admin/advance-payments.parties.index', ['parties' => Party::latest()->paginate(20)]);
    }

    public function create()
    {
        return view('admin/advance-payments.parties.form', ['party' => new Party(), 'action' => route('advance-parties.store')]);
    }

    public function store(StorePartyRequest $request)
    {
        Party::create($request->validated());
        return redirect()->route('advance-parties.index')->with('success', 'Party created.');
    }

    public function edit(Party $party)
    {
        return view('admin/advance-payments.parties.form', ['party' => $party, 'action' => route('advance-parties.update', $party)]);
    }

    public function update(StorePartyRequest $request, Party $party)
    {
        $party->update($request->validated());
        return redirect()->route('advance-parties.index')->with('success', 'Party updated.');
    }

    public function destroy(Party $party)
    {
        if ($party->advanceReceived()->exists() || $party->advancePaid()->exists()) {
            return back()->withErrors(['party' => 'This party is used by an advance and cannot be deleted.']);
        }
        $party->delete();
        return back()->with('success', 'Party deleted.');
    }
}
