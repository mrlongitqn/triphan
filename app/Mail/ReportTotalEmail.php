<?php

namespace App\Mail;

use App\Repositories\CourseStudentRepository;
use App\Repositories\FeeDetailRepository;
use App\Repositories\FeeRepository;
use App\Repositories\MarkRepository;
use App\Repositories\MarkTypeDetailRepository;
use App\Repositories\RefundRepository;
use App\Repositories\SessionMarkRepository;
use App\Repositories\StudentRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportTotalEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $id;
    /**
     * @var CourseStudentRepository
     */
    private $courseStudentRepository;
    /**
     * @var FeeDetailRepository
     */
    private $feeDetailRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var FeeRepository
     */
    private $feeRepository;
    /**
     * @var RefundRepository
     */
    private $refundRepository;
    /**
     * @var MarkRepository
     */
    private $markRepository;
    /**
     * @var SessionMarkRepository
     */
    private $sessionMarkRepository;
    /**
     * @var MarkTypeDetailRepository
     */
    private $markTypeDetailRepository;
    private $markTypeDetails;
    private $sessionMarks;
    private $student;
    private $courses;
    private $marks;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($markTypeDetails, $sessionMarks, $student,$courses, $marks){;
        $this->markTypeDetails = $markTypeDetails;
        $this->sessionMarks = $sessionMarks;
        $this->student = $student;
        $this->courses = $courses;
        $this->marks = $marks;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail.reporttotal')
            ->with([
                'markTypeDetails'=>$this->markTypeDetails,
                'sessionMarks'=>$this->sessionMarks,
                'student'=>$this->student,
                'courses'=>$this->courses,
                'marks'=>$this->marks
            ])
            ;
    }
}
