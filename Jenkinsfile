pipeline {
	agent none
	stages {
		stage('DependencyCheck'){
			agent any
			stages {
				stage('OWASP DependencyCheck') {
					steps {
						dependencyCheck additionalArguments: '--format HTML --format XML', odcInstallation: 'default'
					}
				}
			}	
			post {
				success {
					dependencyCheckPublisher pattern: 'dependency-check-report.xml'
				}
			}
		}
		stage('Unit test'){
			agent {
				docker {
					image 'composer:2.4'
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
						sh './vendor/bin/phpunit --log-junit logs/unitreport.xml -c src/test/phpunit.xml src/test'
					}
				}
			}
			post {
				always {
					junit testResults: 'logs/unitreport.xml'
				}
			}
		}

		stage('SonarQube'){
			agent any 
			stages {
				stage ('Checkout') { 
					steps {
						git branch:'master', url: 'https://github.com/OWASP/Vulnerable-Web-Application.git'
					} 
				}
				stage('Code Quality Check via SonarQube') { 
					steps {
						script {
							def scannerHome = tool 'SonarQube';
							withSonarQubeEnv('SonarQube') {
								sh "${scannerHome}/bin/sonar-scanner \
												-Dsonar.projectKey=ICT3103_2021 \
												-Dsonar.sources=. \
												-Dsonar.host.url=http://172.18.0.4:9000 \
												-Dsonar.login=1e2d8f368cc8039fb1a611b061305951e93ef617"
							}
						}
					}
				}
			} 
			post {
				always {
					recordIssues enabledForFailure: true, tool: sonarQube()
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