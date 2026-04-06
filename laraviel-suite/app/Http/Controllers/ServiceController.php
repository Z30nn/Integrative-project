<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvailedService;
use App\Models\IncomeTracker;
use App\Models\Service;

class ServiceController extends Controller
{
    public function submit(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'service_id' => 'required|exists:services,service_id',
        'service_date' => 'required|date',
        'payment_method' => 'required|in:over_the_counter,online_payment',
        'total_price' => 'required|numeric|min:0',
        'booking_id' => 'required|string',  // Adjust to your actual field type or table
        'name' => 'required|string',
    ]);

    // Determine the payment status based on the payment method
    $paymentStatus = ($request->payment_method == 'online_payment') ? 'paid' : 'pending';

    // Create a new entry in the availed_services table
    AvailedService::create([
        'booking_id' => $validatedData['booking_id'],
        'guest_name' => $validatedData['name'],
        'service_id' => $validatedData['service_id'],
        'service_date' => $validatedData['service_date'],
        'payment_method' => $validatedData['payment_method'],
        'payment_status' => $paymentStatus,
        'total_price' => $validatedData['total_price'],
    ]);

    // If payment status is 'paid', create an income tracker entry and redirect
    if ($paymentStatus == 'paid') {
        $service = Service::where('service_id', $validatedData['service_id'])->first();

        IncomeTracker::create([
            'customer_name' => $validatedData['name'],
            'booking_id' => $validatedData['booking_id'],
            'availed_service' => $service->service_name,
            'price' => $validatedData['total_price'],
            'payment_status'
        ]);

        // Redirect to the '/' route
        return redirect('view-booking')->with('success', 'Payment successful!');
    }

    // Redirect to the '/' route if payment is not 'paid'
    return redirect('view-booking')->with('info', 'Payment is pending.');
}

public function markAsPaid($id, $booking_id)
{
    // Find the availed service record by ID
    $availedService = AvailedService::find($id);

    // If the record exists and its payment status is not already 'paid'
    if ($availedService && $availedService->payment_status !== 'paid') {
        // Update the payment status to 'paid'
        $availedService->payment_status = 'paid';
        $availedService->save();

        // Get the service details using the service_id from AvailedService
        $service = Service::where('service_id', $availedService->service_id)->first();

        // Create an entry in IncomeTracker
        IncomeTracker::create([
            'customer_name' => $availedService->guest_name,
            'booking_id' => $booking_id,
            'availed_service' => $service->service_name,  // Store only the service name
            'price' => $availedService->total_price,
        ]);
    }

    // Redirect back to the previous page (or wherever you need to)
    return redirect()->back()->with('success', 'Payment status updated to paid.');
}
public function destroy($id)
{
    // Find the service record by ID
    $availedService = AvailedService::find($id);

    if ($availedService) {
        // Delete the service record
        $availedService->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Service deleted successfully.');
    }

    // If the service does not exist, redirect back with an error message
    return redirect()->back()->with('error', 'Service not found.');
}

public function refund($id)
{
    // Find the service record by ID
    $availedService = AvailedService::find($id);

    if ($availedService) {
        // If the payment status is 'paid', remove the corresponding entry in IncomeTracker
        if ($availedService->payment_status == 'paid') {
            // Get the corresponding IncomeTracker record
            $incomeTracker = IncomeTracker::where('customer_name', $availedService->guest_name)
                                          ->where('availed_service', $availedService->service->service_name)
                                          ->where('price', $availedService->total_price)
                                          ->first();

            // If a matching record is found, delete it
            if ($incomeTracker) {
                $incomeTracker->delete();
            }
        }

        // Update the payment status to 'Refunded'
        $availedService->payment_status = 'Refunded';
        $availedService->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Payment status updated to refunded, and income tracker entry removed.');
    }

    // If the service does not exist, redirect back with an error message
    return redirect()->back()->with('error', 'Service not found.');
}

public function update(Request $request, $id)
{
    // Validate input
    $request->validate([
        'service_name' => 'required|string|max:255',
        'availed_service' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
    ]);

    // Find and update service
    $roomService = Service::where('service_id', $id)->firstOrFail();

    $roomService->update([
        'service_name' => $request->service_name,
        'availed_service' => $request->availed_service,
        'description' => $request->description,
        'price' => $request->price,
    ]);

    // Redirect back with a success message
    return redirect()->back()->with('approved', 'Service updated successfully.');
}

//delete a service
public function delete($id)
{
    try {
        // Check if the service exists
        $service = Service::find($id);
        
        // If the service is found, delete it
        if ($service) {
            $service->delete();
            return redirect()->back()->with('approved', 'Service deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Service not found.');
        }
    } catch (\Exception $e) {
        // Log the exception or display the error message
        return redirect()->back()->with('error', 'An error occurred while deleting the service.');
    }
}


}
