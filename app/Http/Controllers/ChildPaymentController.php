<?php

namespace App\Http\Controllers;

use App\Child;
use Illuminate\Http\Request;

class ChildPaymentController extends Controller
{
    public function showPaymentForm(Child $child)
    {
        $child->current_week_total = $child->weeklyTotals();

        $child->past_due = $child->checkin_totals()->where('created_at', '<', startOfWeek())->where('total_amount', '>', 0)->sum('total_amount');
        return view('payment.show')->withChild($child);
    }

    public function payPastDue(Request $request, Child $child)
    {
        $this->validate($request, [
            'past_due_amount' => 'required'
        ]);
        $paymentAmount = $request->past_due_amount;
        $paymentsOverdue = $child->checkin_totals()->where('created_at', '<', startOfWeek())->where('total_amount', '>', 0)->orderBy('id', 'desc')->get();
        $paymentsOverdueTotal = $paymentsOverdue->sum('total_amount');
        if($paymentAmount <= $paymentsOverdueTotal) {
            foreach ($paymentsOverdue as $payment) {
                if($payment->total_amount >= $paymentAmount) {
                    $paymentTotalAmount = $payment->total_amount;
                    $payment->update([
                        'total_amount' => $paymentTotalAmount - $paymentAmount
                    ]);
                    $paymentAmount = $paymentTotalAmount - $paymentAmount;
                    return redirect()->back();
                }
                $paymentAmount = $paymentAmount - $payment->total_amount;
                $payment->update([
                    'total_amount' => 0
                ]);
            }
        }
        $errors['past_due_amount'] = "Payment amount is more then you owe";
        return redirect()->back()->withErrors($errors);
    }

    public function payWeekTotal(Request $request, Child $child)
    {
        $this->validate($request, [
            'total_amount' => 'required'
        ]);

        $paymentAmount = $request->total_amount;
        $weeklyDue = $child->checkin_totals()->whereBetween('created_at', [startOfWeek(), endOfWeek()])->first();
        $weeklyDueTotal = $weeklyDue->total_amount;
        if($paymentAmount <= $weeklyDueTotal) {
            $weeklyDue->update([
                'total_amount' => $weeklyDueTotal - $paymentAmount
            ]);
            return redirect()->back();
        }
        $errors['total_amount'] = "Payment amount is more then you owe";
        return redirect()->back()->withErrors($errors);
    }
}
