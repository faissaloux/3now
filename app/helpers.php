<?php

function something_went_wrong(){
    return response()->json(['error' => trans('api.something_went_wrong')],500);
}

function json_success($message){
    return response()->json(['success' => trans($message)]) ;    
}

function json_error($message){
    return response()->json(['error' => trans($message)],500) ;    
}