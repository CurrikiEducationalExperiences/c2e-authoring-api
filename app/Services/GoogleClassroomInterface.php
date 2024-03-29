<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Playlist;
use App\Models\Activity;
use App\Repositories\GcClasswork\GcClassworkRepositoryInterface;
use App\Repositories\GoogleClassroom\GoogleClassroomRepositoryInterface;

/**
 * Interface for Google Classroom service
 */
interface GoogleClassroomInterface
{

    /**
     * Course create state
     * 
     * @var string
     */
    const COURSE_CREATE_STATE = 'PROVISIONED';

    /**
     * Course work creation type
     * 
     * @var string
     */
    const COURSEWORK_TYPE = 'ASSIGNMENT';

    /**
     * Course work state when published
     * 
     * @var string
     */
    const COURSEWORK_STATE_PUBLISHED = 'PUBLISHED';

    /**
     * Course work state when draft
     * 
     * @var string
     */
    const COURSEWORK_STATE_DRAFT = 'DRAFT';

    /**
     * Active state for a course
     * 
     * @var string
     */
    const COURSE_STATE_ACTIVE = 'ACTIVE';

    /**
     * Turned-In state for an assignment
     * 
     * @var string
     */
    const ASSIGNMENT_STATE_TURNED_IN = 'TURNED_IN';

    /**
     * Returned state for an assignment
     * 
     * @var string
     */
    const ASSIGNMENT_STATE_RETURNED = 'RETURNED';

    /**
     * Get Google Client object
     * 
     * @return \Google_Client
     */
    public function getClient();

    /**
     * Set GcClasswork repository object
     * 
     * @param GcClassworkRepositoryInterface $gcClassworkRepository
     *
     * @return void
     */
    public function setGcClassworkObject(GcClassworkRepositoryInterface $gcClassworkRepository);

    /**
     * Get Google Classroom courses
     * 
     * @param array $params
     * @return array
     */
    public function getCourses($params);

    /**
     * Get a course by id
     * 
     * @param int $id
     * @return \Google_Service_Classroom_Course
     */
    public function getCourse($id);

    /**
     * Create a course in Google Classroom
     * 
     * @param array $data The course data
     * @return \Google_Service_Classroom_Course
     */
    public function createCourse($data);

    /**
     * Create a topic in Google Classroom
     * 
     * @param array $data The topic data
     * @return \Google_Service_Classroom_Topic
     */
    public function createTopic($data);

    /**
     * Create a course work in Google Classroom
     * 
     * @param array $data The course work data
     * @return \Google_Service_Classroom_CourseWork
     */
    public function createCourseWork($data);

    /**
     * Get Topics by course id
     * 
     * @param int $courseId The id of the course
     * @param array $params
     * @return array
     */
    public function getTopics($courseId, $params = []);

    /**
     * Get Topic by id
     *
     * @param string $courseId The id of the course
     * @param string $id The id of the topic
     * @param array $params
     * @return array
     */
    public function getTopicById($courseId, $id, $params = []);

    /**
     * Get or Create a topic in a course.
     * 
     * @param array $data
     * @return \Google_Service_Classroom_Topic
     */
    public function getOrCreateTopic($data);

    /**
     * Get whole project as a course in Google Classroom
     * It will create playlists as topics, and activities as assignments.
     * If a course already exists, then playlists and activities will be created in that.
     *
     * @param Project $project
     * @param int|null $courseId The id of the course
     * @param GoogleClassroomRepositoryInterface $googleClassroomRepository
     * @param $publisherOrg
     * @return array
     * @throws GeneralException
     */
    public function createProjectAsCourse(Project $project, $courseId = null, GoogleClassroomRepositoryInterface $googleClassroomRepository, $publisherOrg);
    
    /**
     * Get whole Playlist as a topic in Google Classroom
     * It will create playlist as the topic, and activities as assignments.
     * If a course and/or topic already exist, then the playlist and activities will be created in that.
     *
     * @param Project $project
     * @param Playlist $playlist
     * @param string|null $courseId
     * @param string|null $topicId
     * @param GoogleClassroomRepositoryInterface $googleClassroomRepository
     * @param $publisherOrg
     * @return array
     * @throws GeneralException
     */
    public function publishPlaylistAsTopic(Project $project, Playlist $playlist, $courseId = null,
        $topicId = null, GoogleClassroomRepositoryInterface $googleClassroomRepository, $publisherOrg);

    /**
     * Get Activity as an assignment in Google Classroom
     * It will create activity as an assignment.
     * If a course and/or topic already exist, then the activity will be created in that.
     *
     * @param Project $project
     * @param Playlist $playlist
     * @param Activity $activity
     * @param string|null $courseId
     * @param string|null $topicId
     * @param GoogleClassroomRepositoryInterface $googleClassroomRepository
     * @param $publisherOrg
     * @return array
     * @throws GeneralException
     */
    public function publishActivityAsAssignment(Project $project, Playlist $playlist, Activity $activity, $courseId = null,
        $topicId = null, GoogleClassroomRepositoryInterface $googleClassroomRepository, $publisherOrg);

    /**
     * Check if student is enrolled in a class
     *
     * @param int $courseId
     * @param string $userId
     * @return \Google_Service_Classroom_Student
     */
    public function getEnrolledStudent($courseId, $userId = "me");

    /**
     * Get first student's submission for a classwork in a course.
     *
     * @param int $courseId
     * @param string $classworkId
     * @param mixed $userId
     * @return string
     */
    public function getFirstStudentSubmission($courseId, $classworkId, $userId = "me");

    /**
     * Get student's submissions for a classwork in a course.
     *
     * @param int $courseId
     * @param string $classworkId
     * @param mixed $userId
     * @return array
     */
    public function getStudentSubmissions($courseId, $classworkId, $userId = "me");

    /**
     * Adds/modifies submission with an attachment
     *
     * @param int $courseId The course id
     * @param string $classworkId The classwork id
     * @param string $id The submission id
     * @param string $attachmentLink The URL for attachment
     * @return string
     */
    public function modifySubmissionAttachment($courseId, $courseWorkId, $id, $attachmentLink);
    
    /**
     * TurnIn an assignment
     *
     * @param int $courseId The course id
     * @param string $classworkId The classwork id
     * @param string $id The submission id
     * @return \Google_Service_Classroom_ClassroomEmpty
     */
    public function turnIn($courseId, $courseWorkId, $id);

    /**
     * Check if user is a teacher in a class
     *
     * @param int $courseId
     * @param string $userId
     * @param array $optParams
     * @return \Google_Service_Classroom_Teacher
     */
    public function getCourseTeacher($courseId, $userId = "me", $optParams = []);

    /**
     * Get student's submission for a classwork in a course by submission id
     *
     * @param int $courseId The Google classroom course id
     * @param string $classworkId The classwork id
     * @param string $id The submission id
     * @return \Google_Service_Classroom_StudentSubmission
     */
    public function getStudentSubmissionById($courseId, $classworkId, $id);

    /**
     * Get user profile by id
     *
     * @param string $userId The Google Classroom user id
     * @return \Google_Service_Classroom_StudentSubmission
     */
    public function getUserProfile($userId);

    /**
     * Check if the assignment is in a submitted state
     * Turned in and 'returned' (by teacher) are both considered submitted for our use case.
     *
     * @param string $state The state of the assignment.
     * @return boolean
     */
    public function isAssignmentSubmitted($state);

     /**
     * Save student data into external database
     *
     * @param array $studentData The Google Classroom student data
     */
    public function saveStudentData($studentData);

}
