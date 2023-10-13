<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class FileAttachment extends Model
{
    use SoftDeletes;
	use Userstamps;
	protected $table = 'file_attachments';

	protected $fillable = [
		'subject',
		'mime_type',
		'file_extension',
		'file_type',
		'file_path',
		'file_name',
		'data'
	];

	public function getFile()
	{
		return $this->file_path.'/'.$this->file_name;
	}
}
