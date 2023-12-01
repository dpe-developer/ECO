<?php

namespace App\Http\Controllers;

use App\Models\NewsFeed;
use App\Models\NewsFeedFile;
use App\Models\FileAttachment;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Auth;

class NewsFeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'newsFeeds' => NewsFeed::get(),
        ];
        return view('news_feed.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news_feed.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);
        $newsFeed = NewsFeed::create([
            'content' => $request->get('content')
        ]);
        if($request->get('file_attachment_id')){
            foreach($request->get('file_attachment_id') as $fileAttachmentID){
                $fileAttachment = FileAttachment::find($fileAttachmentID);
                NewsFeedFile::create([
                    'news_feed_id' => $newsFeed->id,
                    'file_attachment_id' => $fileAttachment->id,
                    'file_type' => $fileAttachment->extension,
                ]);
            }
        }
        return redirect()->route('news_feeds.index')->with('alert-success', 'Post added to Newsfeed');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsFeed  $newsFeed
     * @return \Illuminate\Http\Response
     */
    public function show(NewsFeed $newsFeed)
    {
        if(UserNotification::where([
            ['user_id', Auth::user()->id],
            ['entity_id', $newsFeed->id],
            ['notification_type', 'news_feed'],
            ['is_seen', true],
        ])->doesntExist()){
            UserNotification::create([
                'user_id' => Auth::user()->id,
                'entity_id' => $newsFeed->id,
                'notification_type' => 'news_feed',
                'is_seen' => true,
            ]);
        }
        $data = [
            'newsFeed' => $newsFeed
        ];
        return response()->json([
            'modal_content' => view('news_feed.show', $data)->render()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsFeed  $newsFeed
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsFeed $newsFeed)
    {
        $data = [
            'newsFeed' => $newsFeed
        ];
        return view('news_feed.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewsFeed  $newsFeed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewsFeed $newsFeed)
    {
        $request->validate([
            'content' => 'required'
        ]);
        $newsFeed->update([
            'content' => $request->get('content')
        ]);
        $finalFiles = [];
        if($request->get('file_attachment_id')){
            foreach($request->get('file_attachment_id') as $fileAttachmentID){
                $fileAttachment = FileAttachment::find($fileAttachmentID);
                if(NewsFeedFile::where([
                    ['news_feed_id', $newsFeed->id],
                    ['file_attachment_id', $fileAttachment->id],
                ])->exists()){
                    $newsFeedFile = NewsFeedFile::where([
                        ['news_feed_id', $newsFeed->id],
                        ['file_attachment_id', $fileAttachment->id],
                    ])->first();
                    $finalFiles[] = $newsFeedFile->id;
                }else{
                    $newsFeedFile = NewsFeedFile::create([
                        'news_feed_id' => $newsFeed->id,
                        'file_attachment_id' => $fileAttachment->id,
                        'file_type' => $fileAttachment->extension,
                    ]);
                    $finalFiles[] = $newsFeedFile->id;
                }
            }
        }
        NewsFeedFile::whereNotIn('id', $finalFiles)->delete();

        return redirect()->route('news_feeds.index')->with('alert-success', 'Post UPDATED');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsFeed  $newsFeed
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsFeed $newsFeed)
    {
        $newsFeed->delete();
        return redirect()->route('news_feeds.index')->with('alert-warning', 'Post DELETED');
    }
}
