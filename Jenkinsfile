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
                    agent any
                    steps {
                        script {
                            sh 'echo $PATH'
                        }
                    }
                }

                stage('Headless Browser Test') {
                    agent any
                    steps {
                        node {
                            // Ensure the necessary context is available
                            script {
                                tools {
                                    // Use the name configured in Jenkins global tool configuration
                                    maven 'Maven'
                                }
                                sh 'mvn -B -DskipTests clean package'
                                sh 'mvn test'
                            }
                        }
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
