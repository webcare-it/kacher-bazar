<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function productReview(ReviewRequest $request)
    {
        try{

            $rating = new Review();
            $rating->user_id = auth()->user()->id;
            $rating->product_id = $request->product_id;
            $rating->rating = $request->rating;
            $rating->message = $request->message;
            $rating->save();
            return response()->json([
                'status' => true,
                'message' => 'Rating has been successfully submited.'
            ]);

        }catch(Exception $exception){
            return response()->json([
                'status' => false,
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function productReviewCount($product_id)
    {
        $productReviewCount = Review::where('product_id', $product_id)->get();
        $total = 0;
        $totalRevCount = count($productReviewCount);
        foreach($productReviewCount as $reviewCount){
            $total += $reviewCount->rating;
        }

        if($totalRevCount > 0){
            $avgRating = round($total/$totalRevCount, 2);
        }else{
            $avgRating = 0;
        }
        return $avgRating;
    }
    public function productDetailsReview($product_id)
    {
        $productDetailsReview = Review::where('product_id', $product_id)->get();
        $total = 0;
        $totalRevCount = count($productDetailsReview);
        foreach($productDetailsReview as $reviewCount){
            $total += $reviewCount->rating;
        }

        if($totalRevCount > 0){
            $avgRating = round($total/$totalRevCount, 2);
        }else{
            $avgRating = 0;
        }
        return round($avgRating);
    }

    public function fiveStarRating($product_id)
    {
        $fiveStarRatingCount = Review::where('rating', 5)->where('product_id', $product_id)->get();

        $total = 0;
        $totalReviewCount = count($fiveStarRatingCount);
        foreach($fiveStarRatingCount as $reviewCount){
            $total += $reviewCount->rating;
        }

        if($totalReviewCount > 0){
            $avgFiveRating = round($total/$totalReviewCount, 2);
        }else{
            $avgFiveRating = 0;
        }
        return $avgFiveRating;
    }
    public function fourStarRating($product_id)
    {
        $fourStarRatingCount = Review::where('rating', 4)->where('product_id', $product_id)->get();

        $total = 0;
        $totalReviewCount = count($fourStarRatingCount);
        foreach($fourStarRatingCount as $reviewCount){
            $total += $reviewCount->rating;
        }

        if($totalReviewCount > 0){
            $avgFourRating = round($total/$totalReviewCount, 2);
        }else{
            $avgFourRating = 0;
        }
        return $avgFourRating;
    }
    public function threeStarRating($product_id)
    {
        $threeStarRatingCount = Review::where('rating', 3)->where('product_id', $product_id)->get();

        $total = 0;
        $totalReviewCount = count($threeStarRatingCount);
        foreach($threeStarRatingCount as $reviewCount){
            $total += $reviewCount->rating;
        }

        if($totalReviewCount > 0){
            $avgThreeRating = round($total/$totalReviewCount, 2);
        }else{
            $avgThreeRating = 0;
        }
        return $avgThreeRating;
    }
    public function twoStarRating($product_id)
    {
        $twoStarRatingCount = Review::where('rating', 2)->where('product_id', $product_id)->get();

        $total = 0;
        $totalReviewCount = count($twoStarRatingCount);
        foreach($twoStarRatingCount as $reviewCount){
            $total += $reviewCount->rating;
        }
        if($totalReviewCount > 0){
            $avgTwoRating = round($total/$totalReviewCount, 2);
        }else{
            $avgTwoRating = 0;
        }
        return $avgTwoRating;
    }
    public function oneStarRating($product_id)
    {
        $oneStarRatingCount = Review::where('rating', 1)->where('product_id', $product_id)->get();

        $total = 0;
        $totalReviewCount = count($oneStarRatingCount);
        foreach($oneStarRatingCount as $reviewCount){
            $total += $reviewCount->rating;
        }

        if($totalReviewCount > 0){
            $avgOneRating = round($total/$totalReviewCount, 2);
        }else{
            $avgOneRating = 0;
        }
        return $avgOneRating;
    }
}
