pipeline {
	agent none
	stages {
		stage('Unit test'){
			agent {
				docker {
					image 'composer:latest'
				}
			}
			stages {
				stage('Build') {
					steps {
						sh 'composer install'
					}
				}
				stage('Test') {
					steps {
						sh './vendor/bin/phpunit --log-junit logs/unitreport.xml -c tests/phpunit.xml tests'
					}
				}
			}
			post {
				always {
					junit testResults: 'logs/unitreport.xml'
				}
			}
		}
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
				stage('Headless Browser Test') {
					agent {
						docker {
							image 'maven:3.8.1-adoptopenjdk-11'
							args '-v /root/.m2:/root/.m2'
						}
					}
					stages {
						stage('Build') {
							steps {
								sh 'mvn -B -DskipTests clean package'
							}
						}
						stage('Test') { 
							steps {
								sh 'mvn test' 
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
	}
}