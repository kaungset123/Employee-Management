## Employee Management Project

### Project Overview

**what is this project ?**
>This **employee management system** aims to manage and control the working flow of any enterprise smoothly and  in convenient way.


**what are used ?**
>In building this project, **php laravel framework** is mainly used and **bootstrap**, **javascrip** and also **ajax** are used for a nice looking and well function system, **spaties** package for role and permission , **pdf** generating support packages and others in order to be a well function system.

### Features
>Since an employee management system, there has the role playing features of strong central controlling with role and permission.And other features of **creating project**, **assigning tasks**,  **requesting leave**, **making attendance**, **rating**, **payroll calculating**, **pdf generating** and **others** features are included.

**what are main features ?** 
- **Project Management** 
- **User Management** 
- **Leaving Management** 
- **attendance management** 
- **salary management** 

### System Flow

- Both **Super Admin** and **Admin** are independent from any department.
- They have the access right for **CRUD operations for all the features** that I mentioned above.
- Each department is organized with one department manager, one HR and employees.

As an employee management system, it is likely an up to down control flow of
- **super admin**
- **admin**
- **manager**
- **employee**
- **HR**

**Project**
- As soon as a project is created by **Super Admin** or **Admin**, **notifications** will be sent to all project members to tell about that `now they are in a new project`
- Project members can check their project's status on their own page.
- During project period tasks assigning and controlling are in charge of project manager

**Leave Request**
- Users who have the roles **manager, employee, HR** can make leave request their own.
- Leave request made by **employee** and **HR** are managed by related department manager
- But leave request of **manager** is decided by **admin** 

**Attendance**
- In a department, making attendance is in charge of HR
- Ot time will calculate automatically and effect to the salary

**Payroll**
- HR make the salary calculating process with the aid of this system

**Role & Permission**
- ***Super Admin*** can control overall roles and permissions, ***Admin*** can only control *under* his position *(manager, employee, HR)*

### Notification 
**Project**
- Project deadline notification will be sent **ahead a week before** of actually deadline and **at the day of deadline** to `all projects members` and in addition to `Super Admin` and `Admin`.

**Task**
- When task deadline hit, notification will be sent to related project member and also to project manager

**Attendance**
- When an HR make an attendance for an employee, noti will be sent to that employee

**Leave Request**
- When a user make leave request, noti will be sent to person 
> `Employee` and `HR` -> `Manager`
> `Manager` -> `Admin`

**Payroll**
- When HR make the salary data, noti will be sent to that user
- As soon as all the salary calculation processes in a department are done, notification will be sent to `Super Admin` and `Admin` for that department automatically.

### Definition Rules
**Project**
- The users who are in two **currently running projects** will not be shown on project creation form

**Leave Request**
- **Full-day/half-day** and **annual leave/other leave**  options are available 
- Each user can take **10** annul leaves and won't cut out any fine from salary
- Beyond that limit will be **other leave** type and cut out from salary 

**Rating**
- Rating event is available **once a month**
* *Rating points will turn into bonus according to the **bonus criteria** at the last month of a year*
 

