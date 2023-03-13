pipeline {
  agent {
    kubernetes {
      inheritFrom "build-docker code-scan xuanim mysql-server"
    }
  }


  environment {
    ZENTAO_VERSION = """${sh(
                            returnStdout: true,
                            script: 'cat VERSION'
    ).trim()}"""
    MYSQL_SERVER_HOST = """${sh(
                            returnStdout: true,
                            script: 'hostname -I'
    ).trim()}"""
    MYSQL_ROOT_PASSWORD = 'pass4ci'

    MIDDLE_IMAGE_REPO = "hub.qc.oop.cc/zentao-ztf"
    MIDDLE_IMAGE_TAG = """${sh(
                            returnStdout: true,
                            script: 'echo $BUILD_ID'
    ).trim()}"""
  }


  stages {
     stage('SonarQube and Build Image') {
       parallel {
         stage('SonarQube') {
           steps {
             container('sonar') {
                 withSonarQubeEnv('sonarqube') {
                     catchError(stageResult: 'FAILURE') {
                         sh 'git config --global --add safe.directory $(pwd)'
                         sh 'sonar-scanner -Dsonar.inclusions=$(git diff --name-only HEAD~1|tr "\\n" ",") -Dsonar.analysis.user=$(git show -s --format=%an)'
                    }
               }
             }
           }
           post {
             success {
               echo "stage sonarqube success"
             }
             failure {
               echo "stage sonarqube failure"
            }
          }
        }
         stage('Build Image') {
           steps {
             container('docker') {
                 sh 'docker build --pull . -f Dockerfile.test --build-arg VERSION=${ZENTAO_VERSION} --build-arg MIRROR=true --build-arg MYSQL_HOST=${MYSQL_SERVER_HOST} --build-arg MYSQL_PASSWORD=${MYSQL_ROOT_PASSWORD} -t ${MIDDLE_IMAGE_REPO}:${MIDDLE_IMAGE_TAG}'
                 sh 'docker push ${MIDDLE_IMAGE_REPO}:${MIDDLE_IMAGE_TAG}'
             }
           }
        }
      }
    }

     stage('Unit Test'){
      stages{
        stage('Unittest Init') {
              agent {
                  kubernetes {
                      inheritFrom "xuanim"
                          containerTemplate {
                              name "zentao"
                              image "${MIDDLE_IMAGE_REPO}:${MIDDLE_IMAGE_TAG}"
                              command "sleep"
                              args "99d"
                          }
                  }
              }
              options { skipDefaultCheckout() }

              steps {
                  container('zentao') {
                      sh 'initdb.php ; /apps/zentao/test/ztest init'
                  }
              }
              post {
                success {
                    sh 'echo "stage unit init success"'
                }
                failure {
                    sh 'echo "stage unit init failure"'
                }
              }
          }

        stage('Run Test') {
          parallel {
            stage('UnitTest P1') {
              agent {
                kubernetes {
                  inheritFrom "xuanim"
                  containerTemplate {
                    name "zentao1"
                    image "${MIDDLE_IMAGE_REPO}:${MIDDLE_IMAGE_TAG}"
                    command "sleep"
                    args "99d"
                  }
                }
              }
              options { skipDefaultCheckout() }

              steps {
                container('zentao1') {
                    sh 'initdb.php config'
                    sh '/apps/zentao/test/ztest extract ; /apps/zentao/test/ztest P1 | tee /apps/zentao/test/p1.log'
                    sh 'pipeline-unittest.sh /apps/zentao/test/p1.log'
                }
              }

              post {
                success {
                  sh 'echo /tmp/p1.log'
                  sh 'printenv'
                }
                failure {
                  sh 'failure'
                }
              }

            }
            stage('UnitTest P2') {
              agent {
                kubernetes {
                  inheritFrom "xuanim"
                  containerTemplate {
                    name "zentao2"
                    image "${MIDDLE_IMAGE_REPO}:${MIDDLE_IMAGE_TAG}"
                    command "sleep"
                    args "99d"
                  }
                }
              }
              options { skipDefaultCheckout() }

              steps {
                container('zentao2') {
                    sh 'initdb.php config'
                    sh '/apps/zentao/test/ztest extract ; /apps/zentao/test/ztest P2 | tee /apps/zentao/test/p2.log'
                    sh 'pipeline-unittest.sh /apps/zentao/test/p2.log'
                }
              }

              /*
              post {
                success {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test success"'
                  }
                }
                failure {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test failure"'
                  }
                }
              }
              */
            }
            stage('UnitTest P3') {
              agent {
                kubernetes {
                  inheritFrom "xuanim"
                  containerTemplate {
                    name "zentao3"
                    image "${MIDDLE_IMAGE_REPO}:${MIDDLE_IMAGE_TAG}"
                    command "sleep"
                    args "99d"
                  }
                }
              }
              options { skipDefaultCheckout() }

              steps {
                container('zentao3') {
                    sh 'initdb.php config'
                    sh '/apps/zentao/test/ztest extract ; /apps/zentao/test/ztest P3 | tee /apps/zentao/test/p3.log'
                    sh 'pipeline-unittest.sh /apps/zentao/test/p3.log'
                }
              }

              /*
              post {
                success {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test success"'
                  }
                }
                failure {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test failure"'
                  }
                }
              }
              */
            }
            stage('UnitTest P4') {
              agent {
                kubernetes {
                  inheritFrom "xuanim"
                  containerTemplate {
                    name "zentao4"
                    image "${MIDDLE_IMAGE_REPO}:${MIDDLE_IMAGE_TAG}"
                    command "sleep"
                    args "99d"
                  }
                }
              }
              options { skipDefaultCheckout() }

              steps {
                container('zentao4') {
                    sh 'initdb.php config'
                    sh '/apps/zentao/test/ztest extract ; /apps/zentao/test/ztest P4 | tee /apps/zentao/test/p4.log '
                    sh 'pipeline-unittest.sh /apps/zentao/test/p4.log'
                }
              }

              /*
              post {
                success {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test success"'
                  }
                }
                failure {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test failure"'
                  }
                }
              }
              */
            }
            stage('UnitTest P5') {
              agent {
                kubernetes {
                  inheritFrom "xuanim"
                  containerTemplate {
                    name "zentao5"
                    image "${MIDDLE_IMAGE_REPO}:${MIDDLE_IMAGE_TAG}"
                    command "sleep"
                    args "99d"
                  }
                }
              }
              options { skipDefaultCheckout() }

              steps {
                container('zentao5') {
                    sh 'initdb.php config'
                    sh '/apps/zentao/test/ztest extract ; /apps/zentao/test/ztest P5 | tee /apps/zentao/test/p5.log'
                    sh 'pipeline-unittest.sh /apps/zentao/test/p5.log'
                }
              }

              /*
              post {
                success {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test success"'
                  }
                }
                failure {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test failure"'
                  }
                }
              }
              */
            }
            stage('UnitTest P6') {
              agent {
                kubernetes {
                  inheritFrom "xuanim"
                  containerTemplate {
                    name "zentao6"
                    image "${MIDDLE_IMAGE_REPO}:${MIDDLE_IMAGE_TAG}"
                    command "sleep"
                    args "99d"
                  }
                }
              }
              options { skipDefaultCheckout() }

              steps {
                container('zentao6') {
                    sh 'initdb.php config'
                    sh '/apps/zentao/test/ztest extract ; /apps/zentao/test/ztest P6 | tee /apps/zentao/test/p6.log'
                    sh 'pipeline-unittest.sh /apps/zentao/test/p6.log'
                }
              }

              /*
              post {
                success {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test success"'
                  }
                }
                failure {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test failure"'
                  }
                }
              }
              */
            }
            stage('UnitTest P7') {
              agent {
                kubernetes {
                  inheritFrom "xuanim"
                  containerTemplate {
                    name "zentao7"
                    image "${MIDDLE_IMAGE_REPO}:${MIDDLE_IMAGE_TAG}"
                    command "sleep"
                    args "99d"
                  }
                }
              }
              options { skipDefaultCheckout() }

              steps {
                container('zentao7') {
                    sh 'initdb.php config'
                    sh '/apps/zentao/test/ztest extract ; /apps/zentao/test/ztest P7 | tee /apps/zentao/test/p7.log'
                    sh 'pipeline-unittest.sh /apps/zentao/test/p7.log'
                }
              }

              /*
              post {
                success {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test success"'
                  }
                }
                failure {
                  container('xuanimbot') {
                    sh 'echo "stage unit-test failure"'
                  }
                }
              }
              */
            }

          } // End Parallel
       }
      }
      post{
          success{
              echo 'success'
          }
          failure{
              echo 'failure'
          }
      }
    }//End unittest

  } // End Root Stages
} // End pipeline
