<?php

use App\Models\Conversation;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReactionController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api', 'verified')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('ali', function () {
    return response(['m' => 'hello ali beaf']);
});

Route::group(['middleware' => ['auth:api']], function () {
});

// verification
//  ===============================================================================================================
// send link to email verification
Route::post('/email/verification-notification', [\App\Http\Controllers\Api\EmailVerificationController::class, 'resend'])->name('verification.resend')->middleware('auth:api');

// email verification
Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\Api\EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:api');


//  ===============================================================================================================

Route::post('/forgot', [\App\Http\Controllers\Api\ForgotPasswordController::class, 'forgot']);
Route::post('/reset', [\App\Http\Controllers\Api\ResetPasswordController::class, 'reset']);
Route::post('/register', [\App\Http\Controllers\Api\AuthC::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthC::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Api\AuthC::class, 'logout'])->middleware('auth:api');


///////////////////////////////////////////FRIENDS /////////////////////////////////////////////////
Route::middleware('auth:api')->group(function () {
    Route::prefix('friend')->group(function () {
        Route::get('/index', [\App\Http\Controllers\FriendController::class, 'index']);
        Route::Post('/store', [\App\Http\Controllers\FriendController::class, 'store']);
        Route::get('/show/{id}', [\App\Http\Controllers\FriendController::class, 'show']);
        Route::put('/approve/{friend_request_id}', [\App\Http\Controllers\FriendController::class, 'approveRequest']);
        Route::get('/notaccepted', [\App\Http\Controllers\FriendController::class, 'NotAccepted']);
        Route::delete('/destroy/{id}', [\App\Http\Controllers\FriendController::class, 'destroy']);
    });
});
///////////////////////////////////////////CHAT /////////////////////////////////////////////////

Route::middleware('auth:api')->group(function () {
    Route::prefix('chat')->group(function () {
        Route::post('upload', [\App\Http\Controllers\PictureController::class, 'store']);
        Route::get('conversations', [\App\Http\Controllers\ConversationController::class, 'index']);
        Route::post('conversations', [\App\Http\Controllers\ConversationController::class, 'store']);
        Route::post('conversations/read', [\App\Http\Controllers\ConversationController::class, 'makConversationAsReaded']);
        Route::post('messages', [\App\Http\Controllers\MessageController::class, 'store']);
    });
});
///////////////////////////////// Groups //////////////////////////////////////////////////
Route::middleware('auth:api')->group(function () {
    Route::prefix('groups')->group(function () {
        Route::get('/index', [\App\Http\Controllers\GroupController::class, 'index']);
        Route::Post('/store', [\App\Http\Controllers\GroupController::class, 'store']);
        // Route::get('/post/index/{group_id}', [\App\Http\Controllers\PostGroupController::class, 'index']);
        // Route::Post('/post/store/{group_id?}', [\App\Http\Controllers\PostController::class, 'store']);
        Route::get('/show/{id}', [\App\Http\Controllers\GroupController::class, 'show']);
        Route::put('/update/{id}', [\App\Http\Controllers\GroupController::class, 'update']);
        Route::delete('/destroy/{id}', [\App\Http\Controllers\GroupController::class, 'destroy']);
    });
});
Route::middleware('auth:api')->group(function () {
    Route::prefix('/postgroup/{group_id}')->group(function () {
        Route::post('/store', [\App\Http\Controllers\GroupPostController::class, 'store']);
        Route::get('/index', [\App\Http\Controllers\GroupPostController::class, 'index']);
        Route::get('/index/img_url/{id}', [\App\Http\Controllers\GroupPostController::class, 'indexImg']);
        Route::get('/show/{id}', [\App\Http\Controllers\GroupPostController::class, 'show']);
        Route::put('/update/{id}', [\App\Http\Controllers\GroupPostController::class, 'update']);
        Route::delete('/delete/{id}', [\App\Http\Controllers\GroupPostController::class, 'destroy']);
        Route::get('/views/{id}', [\App\Http\Controllers\GroupPostController::class, 'show']);
    });
    Route::prefix('postgroup/{group_id}/{post}/comment')->group(function () {
        Route::get('/', [\App\Http\Controllers\GroupPostCommentController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\GroupPostCommentController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\GroupPostCommentController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\GroupPostCommentController::class, 'destroy']);
    });
    Route::prefix("/{group_id}/{post}/reactions")->group(function () {
        Route::get('/', [\App\Http\Controllers\GroupPostReactionController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\GroupPostReactionController::class, 'store']);
    });
});
Route::middleware('auth:api')->group(function () {
    Route::prefix('usergroups')->group(function () {
        Route::get('/index/{group_id}', [\App\Http\Controllers\UserGroupController::class, 'index']);
        Route::Post('/store/{group_id}', [\App\Http\Controllers\UserGroupController::class, 'store']);
        Route::get('/show/{id}', [\App\Http\Controllers\UserGroupController::class, 'show']);
        // Route::put('/update/{id}',[\App\Http\Controllers\UserGroupController::class,'update']);
        Route::delete('/destroy/{group_id}', [\App\Http\Controllers\UserGroupController::class, 'destroy']);
    });
});
//////////////////////////////////////////////////////////////////////////
// Route::middleware('auth:api')->group(function()
// {
//     Route::prefix('user')->group(function(){
//     Route::Post('/{user}/add_friend',[\App\Http\Controllers\AddFriendController::class,'addallFriend']);
//     Route::Delete('{user}/remove_friend',[\App\Http\Controllers\AddFriendController::class,'removefriend']);
//     Route::get('/show/{id}',[\App\Http\Controllers\FriendController::class,'show']);
//     Route::put('/update/{id}',[\App\Http\Controllers\FriendController::class,'update']);
//     Route::delete('/destroy/{id}',[\App\Http\Controllers\FriendController::class,'destroy']);

// });
// });

// Route::prefix('/{post}/{comment}/reply')->group(function(){
//     //Route::get('/index',[\App\Http\Controllers\CommentController::class,'index']);
//     Route::post('/store',[\App\Http\Controllers\ReplyController::class,'store']);
//     //Route::put('/update/{id}',[\App\Http\Controllers\CommentController::class,'update']);
//     //Route::delete('/destroy/{id}',[\App\Http\Controllers\CommentController::class,'destroy']);
// });
//     Route::prefix("/{post}/reactions")->group(function (){
//         Route::get('/index', [\App\Http\Controllers\ReactionController::class, 'index']);
//         Route::post('/store', [\App\Http\Controllers\ReactionController::class, 'store']);
//     });

//     Route::prefix("/{post}/{comment}/reactions")->group(function (){
//         Route::get('/indexComment', [\App\Http\Controllers\ReactionController::class, 'indexComment']);
//         Route::post('/storeComment', [\App\Http\Controllers\ReactionController::class, 'storeComment']);
//     });
// Route::Post('/addfriend/{id}',[\App\Http\Controllers\AddFriendController::class,'store'])->middleware('auth:api');
// Route::delete('/deletefriend/{id}',[\App\Http\Controllers\AddFriendController::class,'destroy'])->middleware('auth:api');
