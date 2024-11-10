const mockData = {
  users: [
    { id: '1', name: 'Christine Eva', role: 'student', password: 'password123', isLoggedIn: false, profilePic: '/images/user1.jpg' },
    { id: '2', name: 'Mark Lee', role: 'student', password: 'password456', isLoggedIn: false, profilePic: '/images/user2.jpg' },
    { id: '3', name: 'Jung Jaehyun', role: 'student', password: 'password789', isLoggedIn: false, profilePic: '/images/user3.jpg' },
    { id: '4', name: 'Kim Taeyong', role: 'student', password: 'password101', isLoggedIn: false, profilePic: '/images/user4.jpg' },
    { id: '5', name: 'Admin User', role: 'student', password: 'adminpass', isLoggedIn: false, profilePic: '/images/admin.jpg' },
  ],
  courses: [
    {
      id: '1',
      title: 'Operating System',
      description: 'Learn the basics of operating systems.',
      instructorId: '2',
      language: 'english',
      levelId: '1',
      categoryId: '1',
      color: 'bg-blue-200',
      time: '3 hours',
      type: 'Online' 
    },
    {
      id: '2',
      title: 'Artificial Intelligence',
      description: 'Explore the fundamentals of AI.',
      instructorId: '3',
      language: 'english',
      levelId: '2',
      categoryId: '1',
      color: 'bg-purple-200',
      time: '4 hours', 
      type: 'Online' 
    },
    {
      id: '3',
      title: 'Software Engineering',
      description: 'Detailed insights into software development.',
      instructorId: '4',
      language: 'spanish',
      levelId: '3',
      categoryId: '2',
      color: 'bg-red-200',
      time: '5 hours', 
      type: 'Offline' 
    },
  ],
  lessons: [
    { id: '1', courseId: '1', title: 'Introduction to OS', duration: '30 mins' },
    { id: '2', courseId: '1', title: 'Memory Management', duration: '45 mins' },
    { id: '3', courseId: '2', title: 'Basics of AI', duration: '40 mins' },
    { id: '4', courseId: '3', title: 'Software Design', duration: '60 mins' },
  ],
  enrollments: [
    { id: '1', studentId: '1', courseId: '1', enrollmentDate: '2024-01-01' },
    { id: '2', studentId: '1', courseId: '2', enrollmentDate: '2024-02-01' },
  ],
  reviews: [
    { id: '1', courseId: '1', studentId: '1', rating: 4, comment: 'Very informative' },
    { id: '2', courseId: '2', studentId: '1', rating: 5, comment: 'Excellent content' },
  ],
  progressTracking: [
    { id: '1', studentId: '1', courseId: '1', lessonId: '1', progress: 'completed' },
    { id: '2', studentId: '1', courseId: '2', lessonId: '3', progress: 'in-progress' },
  ],
  categories: [
    { id: '1', name: 'Programming' },
    { id: '2', name: 'Design' },
    { id: '3', name: 'Languages' },
  ],
  difficultyLevels: [
    { id: '1', level: 'Beginner' },
    { id: '2', level: 'Intermediate' },
    { id: '3', level: 'Advanced' },
  ],
  instructorRatings: [
    { id: '1', instructorId: '2', rating: 4.5, comment: 'Great instructor' },
    { id: '2', instructorId: '3', rating: 4.8, comment: 'Very knowledgeable' },
  ],
  onlineUsers: [
    { name: 'Maren Maureen', id: '1094882001' },
    { name: 'Jennifer Jane', id: '1094672000' },
    { name: 'Ryan Herwinds', id: '1094434000' },
    { name: 'Kierra Culhane', id: '1094648202' },
  ],
};

export default mockData;
