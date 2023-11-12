pipeline {
	agent none
	stages {
		stage('Integration UI Test') {
			parallel {
				stage('Deploy') {
					agent any
					steps {
						sh './jenkins/scripts/deploy.sh'
						input message: 'Finished using the web site? (Click "Proceed" to continue)'
						sh './jenkins/scripts/kill.sh'
					}
				}

				stage('Print Path') {
					steps {
						script {
							sh 'echo $PATH'
						}
           			 }
        			}
				stage('Headless Browser Test') {
					agent any 
					tools{
						maven 'Maven' // Use the name configured in Jenkins global tool configuration
					}
					steps {
						sh '/var/jenkins_home/apache-maven-3.6.3/bin/mvn -B -DskipTests clean package'
						sh '/var/jenkins_home/apache-maven-3.6.3/bin/mvn test'
					}
					post {
						always {
							junit 'target/surefire-reports/*.xml'
						}
					}
				}
			}
		}
	}
}