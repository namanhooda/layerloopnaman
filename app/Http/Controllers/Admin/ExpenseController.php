<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $expenses = Expense::latest();

            return DataTables::of($expenses)

                ->addIndexColumn()

                ->editColumn('expense_date', function ($expense) {
                    return $expense->expense_date->format('d M, Y');
                })

                ->editColumn('amount', function ($expense) {
                    return '₹' . number_format($expense->amount, 2);
                })

                ->addColumn('actions', function ($expense) {

                    $editUrl = route('admin.expenses.edit', $expense->id);
                    $deleteUrl = route('admin.expenses.destroy', $expense->id);

                    return '
                    <div class="d-flex align-items-center">

                        <a class="btn btn-icon me-1"
                           href="' . $editUrl . '">
                            <i class="ti tabler-edit icon-22px"></i>
                        </a>

                        <form action="' . $deleteUrl . '"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return confirm(\'Are you sure you want to delete this expense?\')">

                            ' . csrf_field() . method_field('DELETE') . '

                            <button type="submit"
                                    class="btn btn-icon btn-sm btn-danger">
                                <i class="ti ti-trash icon-22px"></i>
                            </button>

                        </form>

                    </div>';
                })

                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.expenses.index');
    }

    public function create()
    {
        return view('admin.expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        Expense::create($request->only([
            'expense_date',
            'title',
            'category',
            'amount',
            'payment_method',
            'description',
        ]));

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    public function show(Expense $expense)
    {
        return view('admin.expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $expense->update($request->only([
            'expense_date',
            'title',
            'category',
            'amount',
            'payment_method',
            'description',
        ]));

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}
